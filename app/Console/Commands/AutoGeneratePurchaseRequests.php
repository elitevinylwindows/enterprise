<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inventory\StockAlert;
use App\Models\Inventory\Product;
use App\Models\Purchasing\PurchaseRequest;
use App\Models\Purchasing\PurchaseRequestItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AutoGeneratePurchaseRequests extends Command
{
    protected $signature = 'purchase:auto-generate';
    protected $description = 'Auto-generates grouped purchase requests from low stock alerts';

    public function handle()
    {
        DB::beginTransaction();

        try {
            $alerts = StockAlert::with('product')
                ->where('status', 'Low Stock')
                ->whereNull('purchase_request_id') // assuming you’ll add this column
                ->get()
                ->groupBy(fn($a) => $a->product->supplier_id);

            foreach ($alerts as $supplierId => $group) {
                $request = PurchaseRequest::create([
                    'purchase_request_id' => 'PR-' . strtoupper(uniqid()),
                    'requested_by' => 'System', // or assign to a default user
                    'department' => 'Inventory',
                    'request_date' => Carbon::now(),
                    'expected_date' => Carbon::now()->addDays(7),
                    'priority' => 'Medium',
                    'status' => 'pending',
                    'notes' => 'Auto-generated from stock alerts',
                ]);

                foreach ($group as $alert) {
                    $price = $alert->product->price ?? 0;
                    $qty = $alert->reorder_qty ?? 0;

                    PurchaseRequestItem::create([
                        'purchase_request_id' => $request->id,
                        'product_id' => $alert->product_id,
                        'description' => $alert->product->description ?? '',
                        'qty' => $qty,
                        'price' => $price,
                        'total' => $qty * $price,
                    ]);

                    $alert->update([
                        'status' => 'Reordered',
                        'purchase_request_id' => $request->id,
                    ]);
                }
            }

            DB::commit();
            $this->info('Purchase requests created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
