<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockOut;
use App\Models\Inventory\Product;
use App\Models\Inventory\Location;
use App\Models\Inventory\StockLevel;

class StockOutController extends Controller
{
    public function index()
{
    $stockOuts = StockOut::with('product', 'location')->get();
    $products = Product::pluck('name', 'id');
    $locations = Location::pluck('name', 'id');

    return view('inventory.stock_out.index', compact('stockOuts', 'products', 'locations'));
}


    public function create()
    {
        $products = Product::pluck('name', 'id');
        $locations = Location::pluck('name', 'id');
        return view('inventory.stock_out.create', compact('products', 'locations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'issued_date' => 'required|date',
            'product_id' => 'required|exists:elitevw_inventory_products,id',
            'location_id' => 'required|exists:elitevw_inventory_locations,id',
            'quantity' => 'required|numeric|min:1',
            'issued_to' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'status' => 'required|string'
        ]);

        // Save stock out
        $stockOut = StockOut::create($request->all());

        // Deduct from stock level
        $stockLevel = StockLevel::firstOrNew([
            'product_id' => $request->product_id,
            'location_id' => $request->location_id,
        ]);

        $current = $stockLevel->stock_available ?? 0;
        $stockLevel->stock_available = max(0, $current - $request->quantity);
        $stockLevel->save();

        return redirect()->route('inventory.stock-out.index')->with('success', 'Stock Out recorded successfully.');
    }

    public function edit($id)
{
    $stockOut = StockOut::findOrFail($id);
    $products = Product::pluck('name', 'id');
    $locations = Location::pluck('name', 'id');

    return view('inventory.stock_out.edit', compact('stockOut', 'products', 'locations'));
}

}
