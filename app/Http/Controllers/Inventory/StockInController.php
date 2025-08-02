<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockIn;
use App\Models\Inventory\Location;
use App\Models\Inventory\Product;
use App\Models\Master\Suppliers\Supplier;

class StockInController extends Controller
{
    public function index()
{
    $stockIns = StockIn::with('product', 'supplier')->get();
    $products = Product::pluck('name', 'id');
    $suppliers = Supplier::pluck('name', 'id');
    $locations = Location::pluck('name', 'id');

    return view('inventory.stock_in.index', compact('stockIns', 'products', 'suppliers', 'locations'));
}


    public function create()
{
    $products = Product::pluck('name', 'id');
    $suppliers = Supplier::pluck('name', 'id');
    $locations = Location::pluck('name', 'id'); 

    return view('inventory.stock_in.create', compact('products', 'suppliers', 'locations'));
}

    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'reference_no' => 'required|string|max:255',
        'warehouse' => 'required|string',
        'location_id' => 'nullable|integer',
        'product_id' => 'required|exists:elitevw_inventory_products,id',
        'quantity' => 'required|numeric|min:1',
        'received_date' => 'required|date',
        'supplier_id' => 'required|exists:elitevw_master_suppliers,id',
        'status' => 'required|string',
        'note' => 'nullable|string'
    ]);

    // Create stock-in record
    $stockIn = StockIn::create($request->all());

    // Update or create stock level
    $stockLevel = \App\Models\Inventory\StockLevel::firstOrNew([
        'product_id' => $request->product_id,
        'location_id' => $request->location_id,
    ]);

    $stockLevel->stock_available = ($stockLevel->stock_available ?? 0) + $request->quantity;
    $stockLevel->save();

    return redirect()->route('inventory.stock-in.index')->with('success', 'Stock In record created and stock updated successfully.');
}


    public function edit($id)
{
    $stockIn = StockIn::findOrFail($id);
    $products = Product::pluck('name', 'id');
    $suppliers = Supplier::pluck('name', 'id');
    $locations = Location::pluck('name', 'id'); // ✅ Add this

    return view('inventory.stock_in.edit', compact('stockIn', 'products', 'suppliers', 'locations'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'reference_no' => 'required|string|max:255',
            'warehouse' => 'required|string',
            'location_id' => 'nullable|integer',
            'product_id' => 'required|exists:elitevw_inventory_products,id',
            'quantity' => 'required|numeric|min:1',
            'received_date' => 'required|date',
            'supplier_id' => 'required|exists:elitevw_master_suppliers,id',
            'status' => 'required|string',
            'note' => 'nullable|string'
        ]);

        $stockIn = StockIn::findOrFail($id);
        $stockIn->update($request->all());

        return redirect()->route('inventory.stock-in.index')->with('success', 'Stock In record updated successfully.');
    }

   
public function productsByLocation($locationId)
{
    $products = \App\Models\Inventory\StockLevel::with('product')
        ->where('location_id', $locationId)
        ->get()
        ->pluck('product.name', 'product_id');

    return response()->json($products);
}



}
