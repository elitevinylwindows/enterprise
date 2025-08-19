<?php

namespace App\Services;

use App\Models\Sales\Order;
use App\Models\Sales\Invoice;
use App\Models\Sales\Quote;
use App\Models\Manufacturing\JobPool;
use Illuminate\Support\Facades\DB;

class JobPoolEnqueueService
{
    /**
     * Create Job Pool rows from a quote's items.
     * Returns number of newly created rows (dedup by quote_item_id).
     */
    public function enqueueFromOrder(Order $order): int
    {
        $cust  = $order->customer;

        $items = $order->items()->get();
        if ($items->isEmpty()) return 0;

        return DB::transaction(function () use ($order, $cust, $items) {
            $count = 0;

            foreach ($items as $it) {
                // Dedup: do not create duplicates if already queued
                $jobNo = 'JOB-' . $order->id . '-' . $it->id;

                $exists = JobPool::query()
                    ->where('order_item_id', $it->id)
                    ->orWhere('job_order_number', $jobNo)
                    ->exists();

                if ($exists) continue;

                JobPool::create([
                    'order_id'              => $order?->id,                          // needed by your index blade
                    'order_item_id'         => $it->id,                               // unique guard (add migration if you haven't)
                    'job_order_number'      => $jobNo,
                    // columns you show in your table
                    'customer_number'       => $order->customer->customer_number,
                    'customer_name'         => $order->customer->customer_name,
                    'series'                => $it->series_id,                        // or map to readable series text if desired
                    'color'                 => $it->color_config,                     // adjust if you prefer ext/int mix
                    'frame_type'            => $it->frame_type,
                    'qty'                   => $it->qty ?? 1,
                    'line'                  => $it->series_type,                      // your table shows this
                    'delivery_date'         => $order->expected_delivery_date,
                    'type'                  => 'order',                               // semantic tag for your filter
                    'production_status'     => 'queued',
                    'profile'               => $it->grid_profile ?? null,             // you display profile
                    'entry_date'            => now()->toDateString(),
                    'last_transaction_date' => now(),
                ]);

                $count++;
            }

            // mark order for reference
            $order->update(['sent_to_job_pool_at' => now()]);

            return $count;
        });
    }

    /** 48‑hour window satisfied if now >= created_at+48h OR order is_rush. */
    public function editHoldSatisfied(Order $order): bool
    {
        $end = $order->editable_until ?? optional($order->created_at)?->copy()->addHours(48);
        return $order->is_rush || (now()->greaterThanOrEqualTo($end ?? now()->addHours(48)));
    }

    /** Any paid/partially_paid/fully_paid or paid_amount>0 counts as "payment on file". */
    public function paymentOnFile(Invoice $invoice): bool
    {
        if (!$invoice) return false;
        $status = strtolower((string) $invoice->status);
        if (in_array($status, ['paid', 'partially_paid', 'fully_paid'])) return true;
        return (float)($invoice->paid_amount ?? 0) > 0;
    }
}
