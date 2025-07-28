<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Invoice;
use App\Models\Master\Customers\Customer;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->get();
        return view('sales.invoices.index', compact('invoices'));
    }

public function create()
{
    $customers = \App\Models\Master\Customers\Customer::all();
    return view('sales.invoices.create', compact('customers'));
}



    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:elitevw_master_customers,id',
            'invoice_date' => 'required|date',
            'net_price' => 'required|numeric',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'paid_amount' => 'nullable|numeric',
            'remaining_amount' => 'nullable|numeric',
        ]);

        Invoice::create($request->all());

        return redirect()->route('sales.invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::pluck('customer_name', 'id');
        return view('sales.invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:elitevw_master_customers,id',
            'invoice_date' => 'required|date',
            'net_price' => 'required|numeric',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'paid_amount' => 'nullable|numeric',
            'remaining_amount' => 'nullable|numeric',
        ]);

        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

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
