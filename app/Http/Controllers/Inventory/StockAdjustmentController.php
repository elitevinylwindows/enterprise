<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockAdjustment;
use App\Models\Inventory\Product;
use App\Models\Inventory\StockLevel;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index()
{
    $adjustments = StockAdjustment::with('product')->get();
    $products = \App\Models\Inventory\Product::pluck('name', 'id');

    return view('inventory.stock_adjustments.index', compact('adjustments', 'products'));
}


    public function create()
    {
        $products = Product::pluck('name', 'id');
        return view('inventory.stock_adjustments.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date'         => 'required|date',
            'reference_no' => 'nullable|string',
            'product_id'   => 'required|exists:elitevw_inventory_products,id',
            'quantity'     => 'required|numeric',
            'reason'       => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            $adjustment = StockAdjustment::create([
                'date'         => $request->date,
                'reference_no' => $request->reference_no,
                'product_id'   => $request->product_id,
                'quantity'     => $request->quantity,
                'reason'       => $request->reason,
                'status'       => 'completed',
            ]);

            $stock = StockLevel::where('product_id', $request->product_id)->first();

            if ($stock) {
                $stock->stock_available += $request->quantity;
                $stock->save();
            } else {
                StockLevel::create([
                    'product_id'       => $request->product_id,
                    'stock_available'  => $request->quantity,
                    'stock_on_hand'    => $request->quantity,
                    'stock_reserved'   => 0,
                    'minimum_level'    => 0,
                    'maximum_level'    => 0,
                    'reorder_level'    => 0,
                    'location_id'      => 1, // or set dynamically if needed
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Stock adjustment created and stock level updated.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
