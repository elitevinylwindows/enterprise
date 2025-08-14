<?php

namespace App\Http\Controllers\Sales;

use App\Helper\FirstServe;
use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
use App\Models\CustomerPaymentMethod;
use Illuminate\Http\Request;
use App\Models\Sales\Invoice;
use App\Models\Master\Customers\Customer;
use App\Models\Sales\InvoicePayment;
use App\Models\Sales\Order;
use App\Models\Sales\Quote;
use App\Services\QuickBooksService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index(Request $request)
{
    $status = $request->get('status', 'all');

    $invoices = Invoice::with(['customer', 'order', 'quote'])
        ->when($status === 'deleted', function($query) {
            return $query->onlyTrashed();
        })
        ->when($status === 'fully_paid', function($query) {
            return $query->where('status', 'fully_paid');
        })
        ->when($status === 'partially_paid', function($query) {
            return $query->where('status', 'partially_paid');
        })
        ->when($status === 'pending', function($query) {
            return $query->where('status', 'pending');
        })
        ->latest()
        ->get();

    return view('sales.invoices.index', compact('invoices', 'status'));
}

    public function create()
    {
        $customers = Customer::pluck('customer_name', 'id');
        $orders = Order::pluck('order_number', 'id');
        $quotes = Quote::pluck('quote_number', 'id');

        return view('sales.invoices.create', compact('customers', 'orders', 'quotes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quote_number'      => 'required|string|max:50',
            'customer_number'   => 'required|string|max:50',
            'customer_name'     => 'required|string|max:255',
            'invoice_number'    => 'required|string|max:50|unique:elitevw_sales_invoices,invoice_number',
            'invoice_date'      => 'required|date',
            'order_number'      => 'nullable|string|max:50',
            'notes'             => 'nullable|string',
            'status'            => 'required|string|max:50',
            'billing_address'   => 'nullable|string|max:255',
            'billing_city'      => 'nullable|string|max:100',
            'billing_state'     => 'nullable|string|max:100',
            'billing_zip'       => 'nullable|string|max:20',
            'billing_phone'     => 'nullable|string|max:20',
            'billing_email'     => 'nullable|email|max:255',
            'delivery_address'  => 'nullable|string|max:255',
            'delivery_city'     => 'nullable|string|max:100',
            'delivery_state'    => 'nullable|string|max:100',
            'delivery_zip'      => 'nullable|string|max:20',
            'delivery_phone'    => 'nullable|string|max:20',
            'delivery_email'    => 'nullable|email|max:255',
        ]);

        try {
            DB::beginTransaction();
            $quote = Quote::where('quote_number', $request->quote_number)->firstOrFail();
            $order = Order::where('order_number', $request->order_number)->first();
            $invoice = quoteToInvoice($quote, $order);
            DB::commit();
            return redirect()->route('sales.invoices.index')->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            dd($e);
            Log::error('Error creating invoice: ' . $e->getMessage());
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::pluck('customer_name', 'id');
        $orders = Order::pluck('order_number', 'id');
        $quotes = Quote::pluck('quote_number', 'id');

        return view('sales.invoices.edit', compact('invoice', 'customers', 'orders', 'quotes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'required_payment_type' => 'nullable|string|in:percentage,fixed',
            'required_payment_fixed' => 'nullable|numeric',
            'required_payment_percentage' => 'nullable|numeric|min:0|max:100',
            'discount' => 'nullable|numeric',
            'sub_total' => 'required|numeric',
            'tax' => 'nullable|numeric',
            'shipping' => 'nullable|numeric',
            'total' => 'required|numeric',
            'due_date'  => 'nullable|date',
        ]);

        $invoice = Invoice::findOrFail($id);

        $invoice->update($request->all());

        if ($request->required_payment_type == 'percentage') {
            $invoice->required_payment = ($invoice->sub_total * $request->required_payment_percentage) / 100;
        } else {
            $invoice->required_payment = $request->required_payment_fixed;
        }

        $invoice->save();

        // if ($invoice->serve_invoice_id) {
        //     $firstServe = new FirstServe();
        //     $firstServe->updateInvoiceAmounts($invoice);
        // } else {
        //     // If the invoice is not yet created in FirstServe, create it
        //     $firstServe = new FirstServe();
        //     $firstServeInvoice = $firstServe->createInvoice($invoice);

        //     if ($firstServeInvoice) {
        //         $invoice->update([
        //             'gateway_response' => json_encode($firstServeInvoice),
        //             'serve_invoice_id' => $firstServeInvoice['id'],
        //             'payment_link' => $firstServeInvoice['payment_link'],
        //         ]);
        //     }
        // }

        return redirect()->route('sales.invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();
        return redirect()->route('sales.invoices.index')->with('success', 'Invoice deleted.');
    }

    public function payment($id)
    {
        $invoice = Invoice::findOrFail($id);
        $total = $invoice->total ?? 0;
        $firstServe = new FirstServe();
        $firstServePaymentMethods = $firstServe->getPaymentMethods($invoice->customer);
        return view('sales.invoices.payment', compact('total', 'invoice', 'firstServePaymentMethods'));
    }

    public function pay(Request $request, $id)
    {
        $validated = $request->validate([
            'ipm_deposit_type' => 'required|in:percent,amount',
            'ipm_deposit_method' => 'required|in:card,echeck,bank',
            'is_deposit' => 'required|in:true,false,1,0',
            'percentage' => 'required_if:ipm_deposit_type,percent|nullable|numeric|min:0|max:100',
            'fixed_amount' => 'required_if:ipm_deposit_type,amount|nullable|numeric|min:0',
            'amount_calculated' => 'required_if:ipm_deposit_type,percent|nullable|numeric|min:0',
            'deposit_card_number' => 'nullable|digits_between:13,19',
            'charge_card' => 'nullable',
            'deposit_saved_card_id' => 'nullable',
            'deposit_card_cvv' => 'nullable|digits_between:3,4',
            'deposit_card_expiry' => [
                'nullable',
                'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/',
                function ($attribute, $value, $fail) {
                    if (preg_match('/^(0[1-9]|1[0-2])\/([0-9]{2})$/', $value, $matches)) {
                        $currentYear = (int) date('y');
                        $expiryYear = (int) $matches[2];
                        if ($expiryYear < $currentYear) {
                            $fail('The card expiry year must not be less than the current year.');
                        }
                    }
                }
            ],
            'deposit_card_zip' => 'nullable|string|max:20',
            'deposit_bank_account' => 'required_if:ipm_deposit_method,echeck,bank|nullable|string|max:50',
            'deposit_bank_routing' => 'required_if:ipm_deposit_method,echeck,bank|nullable|string|max:50',
        ],
        [
            'deposit_card_expiry.regex' => 'The card expiry must be in MM/YY format.',
            'deposit_card_number.digits_between' => 'The card number must be between 13 and 19 digits.',
            'deposit_card_cvv.digits_between' => 'The CVV must be between 3 and 4 digits.',
        ]);

        try{
            DB::beginTransaction();
            $firstServe = new FirstServe();
            $invoice = Invoice::findOrFail($id);

            $amount = $validated['amount_calculated'] ?? $validated['fixed_amount'] ?? 0;

            $totalPaid = InvoicePayment::where('invoice_id', $invoice->id)
                ->whereIn('payment_type', ['deposit', 'payment'])
                ->sum('payment_amount');
            
            $fullyPaid = $totalPaid >= floatval($invoice->total) ? true : false;
            if($request->charge_card == "true") {
                if($amount <= $invoice->remaining_amount) {
                    $charge = $firstServe->chargeCard($invoice->customer, $amount, $validated['deposit_saved_card_id'], $invoice->invoice_number, $invoice->order->order_number);

                    if($charge['status'] == 'Approved') {
                        $payment = InvoicePayment::create([
                            'invoice_id' => $invoice->id,
                            'payment_type' => $request->is_deposit === 'true' ? 'deposit' : 'payment',
                            'deposit_type' => $request->ipm_deposit_type,
                            'deposit_method' => $request->ipm_deposit_method,
                            'deposit_card_number' => $request->deposit_card_number,
                            'deposit_card_cvv' => $request->deposit_card_cvv,
                            'deposit_card_expiry' => $request->deposit_card_expiry,
                            'deposit_card_zip' => $request->deposit_card_zip,
                            'amount_calculated' => $request->amount_calculated ?? 0,
                            'fixed_amount' => $request->fixed_amount ?? 0,
                            'percentage' => $request->percentage ?? 0,
                            'payment_amount' => $amount,
                            'status' => 'Approved',
                            'deposit_bank_account' => $request->deposit_bank_account,
                            'deposit_bank_routing' => $request->deposit_bank_routing,
                        ]);
                    }

                    $fullyPaid = $totalPaid >= floatval($invoice->total) ? true : false;
                    $invoice->remaining_amount = $totalPaid < floatval($invoice->total) ? floatval($invoice->total) - $totalPaid : 0;
                    $invoice->paid_amount = $totalPaid >= floatval($invoice->total) ? floatval($invoice->total) : $totalPaid;
                    
                    $invoice->status = $invoice->remaining_amount <= 0 ? 'fully_paid' : 'partially_paid';
                    $invoice->save();
                
                } else {
                    return redirect()->back()->with('error', 'Payment amount exceeds remaining invoice amount.');
                }
            } else {
                if(!$fullyPaid) {
                    $firstServeInvoice = $firstServe->updateInvoiceAmounts($invoice, $amount);
                    if ($firstServeInvoice) {
                        $remainingAmount = $invoice->total - $amount;

                        $invoice->update([
                            'gateway_response' => json_encode($firstServeInvoice),
                            'serve_invoice_id' => $firstServeInvoice['id'],
                            'payment_link' => $firstServeInvoice['payment_link'],
                            'payment_link' => $firstServeInvoice['payment_link'],
                            'required_payment' => $amount,
                            'remaining_amount' => $remainingAmount,
                        ]);
                        
                        $mail = new InvoiceMail($invoice);
                        Mail::to($invoice->customer->email)->send($mail);
                    }
                }
            }

            if($request->deposit_card_number && $request->deposit_card_expiry && $request->deposit_card_zip) {
                $this->addPaymentMethodToCustomer($invoice->customer, $request->deposit_card_number, $request->deposit_card_expiry, $request->deposit_card_zip);
            }

            DB::commit();

            return redirect()->route('sales.invoices.index')->with('success', 'Payment recorded successfully.');
        }catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            Log::error($error['error_message']);
            return redirect()->back()->with('error', 'Payment failed: ' . $error['error_message']);
        }
    }

    public function getCustomer($customer_number)
    {
        $customer = DB::table('elitevw_master_customers')
            ->where('customer_number', $customer_number)
            ->first();

        if ($customer) {
            return response()->json(['customer_name' => $customer->customer_name]);
        } else {
            return response()->json(['error' => 'Customer not found'], 404);
        }
    }

    public function show($id)
    {
        $invoice = Invoice::with(['customer', 'order', 'quote'])->findOrFail($id);
        return view('sales.invoices.show', compact('invoice'));
    }

    public function syncToQuickbooks(Invoice $invoice)
    {
        // Get invoice data
        $invoiceData = [
            'customer_name' => $invoice->customer->name,
            'invoice_number' => $invoice->invoice_number, // Match your DB field
            'date' => $invoice->invoice_date,
            'items' => $invoice->items->map(function ($item) {
                return [
                    'name' => $item->name,
                    'quantity' => $item->quantity,
                    'rate' => $item->price,
                ];
            }),
        ];

        // Delegate QBXML generation
        $qbxml = app(QuickBooksService::class)->generateInvoiceQBXML($invoiceData);

        // Queue the request with company file context
        QuickBooksQueue::create([
            'qb_action' => 'InvoiceAdd',
            'qbxml' => $qbxml,
            'company_file' => 'YourCompanyFile.QBW', // Optional: Store the target QB file
        ]);

        return redirect()->back()->with('success', 'Invoice queued for QuickBooks sync.');
    }


    public function restore($id)
    {
        Invoice::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('sales.invoices.index', ['status' => 'deleted'])
            ->with('success', 'Invoice restored successfully');
    }

    public function forceDelete($id)
    {
        Invoice::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('sales.invoices.index', ['status' => 'deleted'])
            ->with('success', 'Invoice permanently deleted');
    }

    public function email($id)
    {
        $invoice = Invoice::findOrFail($id);
        $mail = new InvoiceMail($invoice);
        Mail::to($invoice->customer->email)->send($mail);

        return redirect()->route('sales.invoices.index')->with('success', 'Invoice email sent successfully.');
    }

    public function addPaymentMethodToCustomer($customer, $card, $expiry, $zip)
    {
        try {

            $expiry = explode('/', $expiry ?? '');
            $expiryMonth = trim($expiry[0] ?? '');
            $expiryYear = trim($expiry[1] ?? '');
            $cardDetails = [
                'card'         => str_replace(' ', '', trim($card ?? '')),
                'expiry_month' => (int) $expiryMonth,
                'expiry_year'  => strlen($expiryYear) === 2 ? (int)('20' . $expiryYear) : (int)$expiryYear,
                'zip'          => trim($zip ?? ''),
            ];


            $firstServe = new FirstServe();
            $firstServePaymentMethod = $firstServe->createPaymentMethod($customer, $cardDetails);
            Log::info("FirstServe Payment Method Created: " . json_encode($firstServePaymentMethod));
            if($firstServePaymentMethod) {
                $paymentMethod = $firstServePaymentMethod['id'];
                return $paymentMethod;
            } else {
                Log::error("Failed to create payment method in FirstServe for customer ID: {$customer->id}");
            }
        } catch (\Exception $e) {
            $error = json_decode($e->getResponse()->getBody()->getContents(), true);
            Log::error($error['error_details']['error']);
            return redirect()->back()->with('error', 'Failed to add payment method: ' . $error['error_details']['error']);
            
        }
    }
}
