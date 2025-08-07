<?php

namespace App\Http\Controllers\Sales;

use App\Helper\FirstServe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Invoice;
use App\Models\Master\Customers\Customer;
use App\Models\Sales\Order;
use App\Models\Sales\Quote;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'customer_id' => 'required|exists:elitevw_master_customers,id',
            'order_id' => 'nullable|exists:elitevw_sales_orders,id',
            'quote_id' => 'nullable|exists:elitevw_sales_quotes,id',
            'invoice_number' => 'required|string|unique:elitevw_sales_invoices,invoice_number',
            'invoice_date' => 'required|date',
            'net_price' => 'required|numeric',
            'paid_amount' => 'nullable|numeric',
            'remaining_amount' => 'nullable|numeric',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        Invoice::create($request->all());

        return redirect()->route('sales.invoices.index')->with('success', 'Invoice created successfully.');
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

        if($request->required_payment_type == 'percentage') {
            $invoice->required_payment = ($invoice->sub_total * $request->required_payment_percentage) / 100;
        } else {
            $invoice->required_payment = $request->required_payment_fixed;
        }

        $invoice->save();

        if($invoice->serve_invoice_id) {
            $firstServe = new FirstServe();
            $firstServe->updateInvoiceAmounts($invoice);
        } else {
            // If the invoice is not yet created in FirstServe, create it
            $firstServe = new FirstServe();
            $firstServeInvoice = $firstServe->createInvoice($invoice);

            if($firstServeInvoice) {
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
}
