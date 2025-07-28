<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return view('sales.orders.index');
    }
    public function create()
    {
        return view('sales.orders.create');
    }
    
    public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'customer_name' => 'required|string',
        'order_type' => 'required|string',
        'order_date' => 'required|date',
        'products' => 'required|array',
    ]);

    return redirect()->route('sales.orders.index')->with('success', 'Orders created successfully!');
}
}
