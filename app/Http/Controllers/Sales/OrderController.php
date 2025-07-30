<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sales\Order;
use App\Models\Master\Customers\Customer;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('customer')->get();
        return view('sales.orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::pluck('customer_name', 'id');
        return view('sales.orders.create', compact('customers'));
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

        Order::create($request->all());

        return redirect()->route('sales.orders.index')->with('success', 'Order created successfully.');
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id); 
        $customers = Customer::pluck('customer_name', 'id');
        return view('sales.orders.edit', compact('order', 'customers'));
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

        $order = Order::findOrFail($id);
        $order->update($request->all());

        return redirect()->route('sales.orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        Order::findOrFail($id)->delete();
        return redirect()->route('sales.orders.index')->with('success', 'Order deleted.');
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
