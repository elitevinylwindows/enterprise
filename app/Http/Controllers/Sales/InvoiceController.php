<?php

namespace App\Http\Controllers\Sales;

use App\Helper\FirstServe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Invoice;
use App\Models\Master\Customers\Customer;
use App\Models\Sales\Order;
use App\Models\Sales\Quote;
use App\Services\QuickBooksService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['customer', 'order', 'quote'])->get(); // include relations
        return view('sales.invoices.index', compact('invoices'));
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


    public function email($id)
    {
        $invoice = Order::findOrFail($id);
        Mail::to($invoice->customer->email)->send(new InvoiceMail($invoice));

        return redirect()->route('sales.invoices.index')->with('success', 'Invoice email sent successfully.');
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
            'ipm_deposit_type'   => 'required|in:percent,fixed',
            'ipm_deposit_method' => 'required|in:card,cash,bank', // adjust allowed methods as needed
            'deposit_card_number' => [
                'nullable',
                'required_if:ipm_deposit_method,card',
                'regex:/^\d{4}\s\d{4}\s\d{4}\s\d{4}$/', // 16 digits with spaces every 4
            ],
            'deposit_card_cvv' => [
                'nullable',
                'required_if:ipm_deposit_method,card',
                'digits_between:3,4',
            ],
            'deposit_card_expiry' => [
                'nullable',
                'required_if:ipm_deposit_method,card',
                'regex:/^(0[1-9]|1[0-2])\/\d{2}$/', // MM/YY format
            ],
            'deposit_card_zip' => [
                'nullable',
                'required_if:ipm_deposit_method,card',
                'regex:/^\d{5}(-\d{1,4})?$/', // ZIP or ZIP+4
            ],
            'payment_amount'   => 'required|array',
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
                'regex:/^(0[1-9]|1[0-2])\/\d{2}$/',
            ],
            'payment_card_zip' => 'array',
            'payment_card_zip.*' => [
                'nullable',
                'regex:/^\d{5}(-\d{1,4})?$/',
            ],
        ], [
            // Custom messages
            'deposit_card_number.regex' => 'Deposit card number must be in format XXXX XXXX XXXX XXXX.',
            'deposit_card_expiry.regex' => 'Deposit card expiry must be in MM/YY format.',
            'deposit_card_zip.regex'    => 'Deposit ZIP must be valid (12345 or 12345-6789).',
            'payment_card_number.*.regex' => 'Card number must be in format XXXX XXXX XXXX XXXX.',
            'payment_card_expiry.*.regex' => 'Card expiry must be in MM/YY format.',
            'payment_card_zip.*.regex'    => 'ZIP must be valid (12345 or 12345-6789).',
        ]);

        
        try{
        }catch (\Exception $e) {
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

}
