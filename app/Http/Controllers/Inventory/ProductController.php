<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Suppliers\Supplier;
use App\Models\Inventory\Product;


class ProductController extends Controller
{
public function index()
{
    $products = Product::all();
    return view('inventory.products.index', compact('products'));
}

public function create()
{
    $categories = \App\Models\Inventory\Category::pluck('name', 'id');
    $uoms = \App\Models\Inventory\Uom::pluck('name', 'id');
    $suppliers = \App\Models\Master\Suppliers\Supplier::pluck('name', 'id');

    return view('inventory.products.create', compact('categories', 'uoms', 'suppliers'));
}


   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string',
        'sku' => 'nullable|string',
        'category_id' => 'required|exists:elitevw_inventory_categories,id',
        'uom_id' => 'required|exists:elitevw_inventory_uoms,id',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'unit' => 'nullable|numeric',
        'unit_price' => 'nullable|numeric',
        'supplier_id' => 'nullable|exists:elitevw_master_suppliers,id',
        'status' => 'nullable|string|in:Active,Inactive',
    ]);

    Product::create([
        'name' => $request->name,
        'sku' => $request->sku,
        'category_id' => $request->category_id,
        'uom_id' => $request->uom_id,
        'description' => $request->description,
        'price' => $request->price,
        'unit' => $request->unit,
        'unit_price' => $request->unit > 0 ? ($request->price / $request->unit) : null,
        'supplier_id' => $request->supplier_id,
        'status' => $request->status ?? 'Active',
    ]);

    return redirect()->route('inventory.products.index')
        ->with('success', 'Product created successfully.');
}

   public function edit($id)
{
    $product = Product::findOrFail($id);
    $categories = \App\Models\Inventory\Category::pluck('name', 'id');
    $uoms = \App\Models\Inventory\Uom::pluck('name', 'id');
    $suppliers = \App\Models\Master\Suppliers\Supplier::pluck('name', 'id');

    return view('inventory.products.edit', compact('product', 'categories', 'uoms', 'suppliers'));
}


   public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string',
        'sku' => 'nullable|string',
        'category_id' => 'required|exists:elitevw_inventory_categories,id',
        'uom_id' => 'required|exists:elitevw_inventory_uoms,id',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'unit' => 'nullable|numeric',
        'unit_price' => 'nullable|numeric',
        'supplier_id' => 'nullable|exists:elitevw_master_suppliers,id',
        'status' => 'nullable|string|in:Active,Inactive',
    ]);

    $product = Product::findOrFail($id);
    $product->update([
        'name' => $request->name,
        'sku' => $request->sku,
        'category_id' => $request->category_id,
        'uom_id' => $request->uom_id,
        'description' => $request->description,
        'price' => $request->price,
        'unit' => $request->unit,
        'unit_price' => $request->unit > 0 ? ($request->price / $request->unit) : null,
        'supplier_id' => $request->supplier_id,
        'status' => $request->status ?? 'Active',
    ]);

    return redirect()->route('inventory.products.index')
        ->with('success', 'Product updated successfully.');
}

    public function destroy($id)
{
    $product = Product::findOrFail($id);
    $product->delete();

    return redirect()->route('inventory.products.index')
        ->with('success', 'Product deleted successfully.');
}

}