<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory\StockAdjustment;
use App\Models\Inventory\StockLevel;
use App\Models\Inventory\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index()
{
    $adjustments = StockAdjustment::with('product')->latest()->get();
    $products = Product::pluck('name', 'id');

    return view('inventory.stock_adjustments.index', compact('adjustments', 'products'));
}
   
    
   
public function create()
{
    $products = \App\Models\Product::pluck('name', 'id'); // or 'product_name'
    return view('inventory.stock_adjustments.create', compact('products'));
}

    public function store(Request $request)
{
    $request->validate([
        'date' => 'required|date',
        'reference_no' => 'required|string',
        'product_id' => 'required|exists:elitevw_inventory_products,id',
        'quantity' => 'required|numeric|min:1',
        'reason' => 'nullable|string',
    ]);

    DB::transaction(function () use ($request) {
        // 1. Create the adjustment record
        $adjustment = StockAdjustment::create([
            'date' => $request->date,
            'reference_no' => $request->reference_no,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
        ]);

        // 2. Update the stock_levels table
        $stock = StockLevel::where('product_id', $request->product_id)->first();

        if ($stock) {
            $stock->stock_available -= $request->quantity;
            $stock->save();
        } else {
            // Optionally create a new stock level record
            StockLevel::create([
                'product_id' => $request->product_id,
                'stock_available' => 0 - $request->quantity,
                'reorder_level' => 0,
                'status' => 'low', // default or conditional
            ]);
        }
    });

    return redirect()->route('inventory.stock-adjustments.index')
        ->with('success', 'Stock adjustment recorded and inventory updated.');
}



    public function edit($id) { return view('inventory.stock_adjustments.edit'); }
    public function update(Request $request, $id) {}
    public function destroy($id) {}
}
