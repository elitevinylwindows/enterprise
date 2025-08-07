<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use Illuminate\Http\Request;
use App\Models\Sales\Order;
use App\Models\Master\Customers\Customer;
use App\Models\Sales\Quote;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        $validated = $request->validate([
            'quote_number' => 'required|string|max:20',
            'order_number' => 'required|string|max:20',
            'entry_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:entry_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'shipping' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
            $quote = Quote::where('quote_number', $request->quote_number)->firstOrFail();
            $order = quoteToOrder($quote);
            $order->expected_delivery_date = $request->delivery_date;
            $order->shipping = $request->shipping;
            $order->notes = $request->notes;
            $order->status = $request->status;
            $order->save();

            $mail = new OrderMail($order);
            Mail::to($quote->customer->email)->send($mail);

            DB::commit();

            return redirect()->route('sales.orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e);
            // Log the error or handle it as needed
            Log::error('Order creation failed: ' . $e->getMessage());
            // Return an error response
            return redirect()->back()->withErrors(['error' => 'Failed to create order: ' . $e->getMessage()]);
        }

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
            'quote_number' => 'required|string|max:20',
            'order_number' => 'required|string|max:20',
            'entry_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:entry_date',
            'status' => 'required|string',
            'notes' => 'nullable|string',
            'shipping' => 'required|numeric',
        ]);
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            $order->update($request->all());
            DB::commit();
            return redirect()->route('sales.orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order update failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Failed to update order: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->items()->delete(); // Delete associated items
        $order->delete();

        return redirect()->route('sales.orders.index')->with('success', 'Order deleted successfully.');
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

    public function email($id)
    {
        $order = Order::findOrFail($id);
        Mail::to($order->customer->email)->send(new OrderMail($order));

        return redirect()->back()->with('success', 'Order email sent successfully.');
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('sales.orders.show', compact('order'));
    }
}
