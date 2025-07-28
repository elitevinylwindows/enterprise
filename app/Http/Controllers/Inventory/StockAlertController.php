<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory\StockAlert;
use App\Models\Inventory\StockLevel;
use App\Models\Inventory\Product;
use App\Models\Purchasing\PurchaseRequest;
use App\Models\Purchasing\PurchaseRequestItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class StockAlertController extends Controller
{
    public function index()
    {
        $this->checkAndCreateAlerts(); // auto-sync alerts from stock levels
        $stock_alerts = StockAlert::with('product')->get();
        return view('inventory.stock_alerts.index', compact('stock_alerts'));
    }

    private function checkAndCreateAlerts()
    {
        $stockLevels = StockLevel::with('product')->get();

        foreach ($stockLevels as $level) {
            if (
                $level->reorder_level !== null &&
                $level->stock_available !== null &&
                $level->stock_available <= $level->reorder_level
            ) {
                $alert = StockAlert::firstOrNew(['product_id' => $level->product_id]);

                $alert->reorder_level  = $level->reorder_level;
                $alert->current_stock  = $level->stock_available; // sync from stock_levels
                $alert->status         = 'Low Stock';
                $alert->alert_date     = now();

                // preserve entered reorder_qty if already exists
                $alert->reorder_qty = $alert->reorder_qty ?? 0;

                $alert->save();
            } else {
                $existing = StockAlert::where('product_id', $level->product_id)->first();
                if ($existing) {
                    $existing->status = 'Reordered';
                    $existing->current_stock = $level->stock_available;
                    $existing->save();
                }
            }
        }
    }

    public function edit($id)
{
    $stock_alert = StockAlert::findOrFail($id);
    $products = Product::pluck('name', 'id');
    return view('inventory.stock-alerts.edit', compact('stock_alert', 'products'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'reorder_level' => 'nullable|numeric',
            'reorder_qty'   => 'nullable|numeric',
            'status'        => 'required|string',
            'alert_date'    => 'nullable|date',
        ]);

        $alert = StockAlert::findOrFail($id);

        $stockLevel = StockLevel::where('product_id', $alert->product_id)->first();
        $currentStock = $stockLevel?->stock_available ?? 0;

        $alert->update([
            'reorder_level' => $request->reorder_level,
            'reorder_qty'   => $request->reorder_qty,
            'status'        => $request->status,
            'alert_date'    => $request->alert_date ?? now(),
            'current_stock' => $currentStock,
        ]);

        return redirect()->route('inventory.stock-alerts.index')->with('success', 'Stock alert updated successfully.');
    }
    


public function createPurchaseRequest($id)
{
    $alert = StockAlert::with('product')->findOrFail($id);

    $request = new PurchaseRequest();
    $request->purchase_request_id = 'PR-' . strtoupper(Str::random(6));
    $request->requested_by = auth()->user()->name;
    $request->department = auth()->user()->roles->first()->name ?? 'Unknown';
    $request->request_date = now();
    $request->expected_date = now()->addDays(7);
    $request->priority = 'Medium';
    $request->status = 'pending';
    $request->notes = 'Auto-generated from Stock Alert #' . $alert->id;
    $request->save();

    $product = $alert->product;
    $price = $product->price ?? 0; // Ensure product has 'price' field
    $qty = $alert->reorder_qty;
    $total = $price * $qty;


DB::table('elitevw_purchasing_purchase_request_items')->insert([
    'purchase_request_id' => $request->id,
    'product_id' => $product->id,
    'description' => $product->name ?? 'Unknown Product',
    'qty' => $qty,
    'price' => $price,
    'total' => $total,
    'created_at' => now(),
    'updated_at' => now(),
]);


$alert->update([
    'status' => 'Reordered', // ✅ match exactly what's in the DB column
    'purchase_request_id' => $request->id,
]);



    return redirect()->route('inventory.stock-alerts.index')->with('success', 'Purchase request created successfully.');
}



public function createGroupedPurchaseRequests()
{
    $alerts = StockAlert::with('product.supplier')
        ->where('status', 'Low Stock')
        ->get();

    $grouped = $alerts->groupBy(fn($alert) => $alert->product->supplier_id ?? 0);

    foreach ($grouped as $supplierId => $group) {
        if ($supplierId == 0) continue; // skip products without supplier

        $request = PurchaseRequest::create([
            'purchase_request_id' => 'PR-' . strtoupper(Str::random(6)),
            'requested_by' => auth()->user()->name,
            'department' => auth()->user()->roles->first()->name ?? 'Unknown',
            'request_date' => now(),
            'expected_date' => now()->addDays(7),
            'priority' => 'Medium',
            'status' => 'pending',
            'notes' => 'Auto-generated for supplier ID: ' . $supplierId
        ]);

        foreach ($group as $alert) {
            $product = $alert->product;
            $price = $product->price ?? 0;
            $qty = $alert->reorder_qty;
            $total = $price * $qty;

            DB::table('elitevw_purchasing_purchase_request_items')->insert([
    'purchase_request_id' => $request->id,
    'product_id' => $product->id,
    'description' => $product->name ?? 'Unknown Product',
    'qty' => $qty,
    'price' => $price,
    'total' => $total,
    'created_at' => now(),
    'updated_at' => now(),
]);

$alert->update([
    'status' => 'Reordered', // ✅ match exactly what's in the DB column
    'purchase_request_id' => $request->id,
]);


        }
    }

    return redirect()->route('inventory.stock-alerts.index')->with('success', 'Grouped purchase requests created by supplier.');
}


    public function destroy($id)
    {
        StockAlert::destroy($id);
        return redirect()->route('inventory.stock-alerts.index')->with('success', 'Stock alert deleted.');
    }
}
