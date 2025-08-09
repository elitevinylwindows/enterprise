<?php

namespace App\Http\Controllers\Sales;

use App\Helper\FirstServe;
use App\Http\Controllers\Controller;
use App\Mail\InvoiceMail;
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
        ->when($status === 'paid', function($query) {
            return $query->where('payment_status', 'paid');
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
            'required_payment_type' => 'required|string|in:percentage,fixed',
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

        if ($invoice->serve_invoice_id) {
            $firstServe = new FirstServe();
            $firstServe->updateInvoiceAmounts($invoice);
        } else {
            // If the invoice is not yet created in FirstServe, create it
            $firstServe = new FirstServe();
            $firstServeInvoice = $firstServe->createInvoice($invoice);

            if ($firstServeInvoice) {
                $invoice->update([
                    'gateway_response' => json_encode($firstServeInvoice),
                    'serve_invoice_id' => $firstServeInvoice['id'],
                    'payment_link' => $firstServeInvoice['payment_link'],
                ]);
            }
        }

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

        return view('sales.invoices.payment', compact('total', 'invoice'));
    }

    public function pay(Request $request, $id)
    {
        $validated = $request->validate([
            'ipm_tab_type' => 'required|in:deposit,payments',
            'ipm_deposit_type'   => 'required_if:ipm_tab_type,deposit|in:percent,amount',
            'ipm_deposit_method' => 'required_if:ipm_tab_type,deposit|in:card,cash,bank', 
            'fixed_amount' => 'nullable|min:0',
            'percentage' => 'nullable|min:0|max:100',
            'amount_calculated' => 'nullable|numeric|min:0',
            'deposit_card_number' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if (
                        $request->ipm_tab_type === 'deposit' &&
                        $request->ipm_deposit_method === 'card' &&
                        empty($value)
                    ) {
                        $fail('The ' . str_replace('_', ' ', $attribute) . ' field is required when deposit method is card and tab type is deposit.');
                    }
                },
            ],
            'deposit_card_cvv' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    if (
                        $request->ipm_tab_type === 'deposit' &&
                        $request->ipm_deposit_method === 'card' &&
                        empty($value)
                    ) {
                        $fail('The ' . str_replace('_', ' ', $attribute) . ' field is required when deposit method is card and tab type is deposit.');
                    }
                },
                'digits_between:3,4',
            ],
            'deposit_card_expiry' => [
                        'nullable',
                        function ($attribute, $value, $fail) use ($request) {
                        if (
                            $request->ipm_tab_type === 'deposit' &&
                            $request->ipm_deposit_method === 'card' &&
                            empty($value)
                        ) {
                            $fail('The ' . str_replace('_', ' ', $attribute) . ' field is required when deposit method is card and tab type is deposit.');
                        }
                    },
            ],
            'deposit_card_zip' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                        if (
                        $request->ipm_tab_type === 'deposit' &&
                        $request->ipm_deposit_method === 'card' &&
                        empty($value)
                        ) {
                        $fail('The ' . str_replace('_', ' ', $attribute) . ' field is required when deposit method is card and tab type is deposit.');
                        }
                    },
            ],
            'payment_amount'   => 'required_if:ipm_tab_type,payments|array',
            'payment_amount.*' => 'nullable|numeric|min:0.01', // allow null for some indexes
            'ipm_payment_method_*' => 'in:card,cash,bank', // adjust allowed methods
            'payment_card_number' => 'array',
            'payment_card_number.*' => [
                'nullable',
                'regex:/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/',
            ],
            'payment_card_cvv' => 'array',
            'payment_card_cvv.*' => [
                'nullable',
                'digits_between:3,4',
            ],
            'payment_card_expiry' => 'array',
            'payment_card_expiry.*' => [
                'nullable',
            ],
            'payment_card_zip' => 'array',
            'payment_card_zip.*' => [
                'nullable',
            ],
        ], [
            // Custom messages
            'deposit_card_zip.regex'    => 'Deposit ZIP must be valid (12345 or 12345-6789).',
            'payment_card_number.*.regex' => 'Card number must be in format XXXX XXXX XXXX XXXX.',
        ]);

        try{
            DB::beginTransaction();
            $invoice = Invoice::findOrFail($id);

            if ($request->ipm_tab_type === 'deposit') {
                $payment = InvoicePayment::create([
                    'invoice_id' => $invoice->id,
                    'payment_type' => 'deposit',
                    'deposit_type' => $request->ipm_deposit_type,
                    'deposit_method' => $request->ipm_deposit_method,
                    'deposit_card_number' => $request->deposit_card_number,
                    'deposit_card_cvv' => $request->deposit_card_cvv,
                    'deposit_card_expiry' => $request->deposit_card_expiry,
                    'deposit_card_zip' => $request->deposit_card_zip,
                    'amount_calculated' => $request->amount_calculated ?? 0,
                    'fixed_amount' => $request->fixed_amount ?? 0,
                    'percentage' => $request->percentage ?? 0,
                    'payment_amount' => null,
                    'payment_card_number' => null,
                    'payment_card_cvv' => null,
                    'payment_card_expiry' => null,
                    'payment_card_zip' => null,
                    'status' => 'pending',
                ]);

                $depositAmount = 0;
                if ($request->ipm_deposit_type === 'percent') {
                    $depositAmount = floatval($request->amount_calculated);
                    $invoice->update([
                        'deposit_amount' => $depositAmount,
                        'deposit_type' => 'percent',
                        'payment_amount' => $depositAmount,
                        'deposit_method' => $request->ipm_deposit_method,
                        'payment_method' => $request->ipm_deposit_method,
                    ]);
                    $payment->update([
                        'payment_amount' => $depositAmount,
                        'payment_method' => $request->ipm_deposit_method,
                    ]);
                }
                if ($request->ipm_deposit_type === 'amount') {
                    $depositAmount = floatval($request->fixed_amount);
                    $invoice->update([
                        'deposit_amount' => $depositAmount,
                        'deposit_type' => 'amount',
                        'payment_amount' => $depositAmount,
                        'deposit_method' => $request->ipm_deposit_method,
                        'payment_method' => $request->ipm_deposit_method,
                    ]);
                    $payment->update([
                        'payment_amount' => $depositAmount,
                        'payment_method' => $request->ipm_deposit_method,
                    ]);
                }

                // Calculate total paid so far
                $totalPaid = InvoicePayment::where('invoice_id', $invoice->id)
                    ->whereIn('payment_type', ['deposit', 'payment'])
                    ->sum(DB::raw('COALESCE(amount_calculated, 0) + COALESCE(fixed_amount, 0) + COALESCE(payment_amount, 0)'));

                $invoice->status = $totalPaid >= floatval($invoice->total) ? 'fully_paid' : 'partially_paid';
                $invoice->save();
            }

           if ($request->ipm_tab_type === 'payments') {
                $totalThisPayment = 0;
                $cardPaymentIndex = 0; // Separate index for card payments
                $bankPaymentIndex = 0; // Separate index for bank/echeck payments

                foreach ($request->payment_amount as $idx => $amount) {
                    if (empty($amount) || floatval($amount) <= 0) {
                        continue;
                    }

                    $methodKey = "ipm_payment_method_{$idx}";
                    $method = $request->$methodKey ?? null;

                    $data = [
                        'invoice_id' => $invoice->id,
                        'payment_type' => 'payment',
                        'payment_method' => $method,
                        'payment_amount' => $amount,
                        'status' => 'pending',
                    ];

                    if ($method === 'card') {
                        // Use separate card payment index
                        $data['payment_card_number'] = $request->payment_card_number[$cardPaymentIndex] ?? null;
                        $data['payment_card_cvv'] = $request->payment_card_cvv[$cardPaymentIndex] ?? null;
                        $data['payment_card_expiry'] = $request->payment_card_expiry[$cardPaymentIndex] ?? null;
                        $data['payment_card_zip'] = $request->payment_card_zip[$cardPaymentIndex] ?? null;
                        $cardPaymentIndex++; // Move to next card details for next card payment
                    } elseif ($method === 'echeck' || $method === 'bank') {
                        // Use separate bank payment index
                        $data['payment_bank_account'] = $request->payment_bank_account[$bankPaymentIndex] ?? null;
                        $data['payment_bank_routing'] = $request->payment_bank_routing[$bankPaymentIndex] ?? null;
                        $bankPaymentIndex++; // Move to next bank details for next bank payment
                    }

                    InvoicePayment::create($data);
                    $totalThisPayment += floatval($amount);
                }

                // Calculate total paid so far
                $totalPaid = InvoicePayment::where('invoice_id', $invoice->id)
                    ->whereIn('payment_type', ['deposit', 'payment'])
                    ->sum(DB::raw('COALESCE(amount_calculated, 0) + COALESCE(fixed_amount, 0) + COALESCE(payment_amount, 0)'));

                $invoice->status = $totalPaid >= floatval($invoice->total) ? 'fully_paid' : 'partially_paid';
                $invoice->payment_method = $method;
                $invoice->save();
            }

            DB::commit();
            return redirect()->route('sales.invoices.index')->with('success', 'Payment recorded successfully.');
        }catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
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
}
