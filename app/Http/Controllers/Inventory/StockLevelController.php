<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockLevel;
use App\Models\Inventory\Product;
use App\Models\Inventory\Location;

class StockLevelController extends Controller
{
    public function index()
    {
        $stockLevels = StockLevel::with('product')->get();
return view('inventory.stock_levels.index', compact('stockLevels'));

    }
    


public function create()
{
    $products = Product::pluck('name', 'id');
    $locations = Location::pluck('name', 'id');
    return view('inventory.stock_levels.create', compact('products', 'locations'));
}

public function store(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:elitevw_inventory_products,id',
        'location_id' => 'required|exists:elitevw_inventory_locations,id',
        'stock_on_hand' => 'nullable|numeric',
        'stock_reserved' => 'nullable|numeric',
        'stock_available' => 'nullable|numeric',
        'minimum_level' => 'nullable|numeric',
        'maximum_level' => 'nullable|numeric',
        'reorder_level' => 'nullable|numeric',
    ]);

    StockLevel::create($request->all());

    return redirect()->route('inventory.stock-level.index')->with('success', 'Stock level created successfully.');
}

public function edit($id)
{
    $stockLevel = StockLevel::findOrFail($id);
    $products = Product::pluck('name', 'id');
    $locations = Location::pluck('name', 'id');

    return view('inventory.stock_levels.edit', compact('stockLevel', 'products', 'locations'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'product_id' => 'required|exists:elitevw_inventory_products,id',
        'location_id' => 'required|exists:elitevw_inventory_locations,id',
        'stock_on_hand' => 'nullable|numeric',
        'stock_reserved' => 'nullable|numeric',
        'stock_available' => 'nullable|numeric',
        'minimum_level' => 'nullable|numeric',
        'maximum_level' => 'nullable|numeric',
        'reorder_level' => 'nullable|numeric',
    ]);

    $stockLevel = StockLevel::findOrFail($id);
    $stockLevel->update($request->all());

    return redirect()->route('inventory.stock-level.index')->with('success', 'Stock level updated successfully.');
}

}



