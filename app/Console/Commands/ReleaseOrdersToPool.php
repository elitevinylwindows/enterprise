<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sales\Quote;
use App\Models\Sales\Invoice;
use App\Models\Sales\Order;
use App\Services\JobPoolEnqueueService;

class ReleaseOrdersToJobPool extends Command
{
    protected $signature = 'orders:release-to-job-pool';
    
    protected $description = 'Auto-release eligible orders to Job Pool after 48h hold, per business rules';

    public function handle(JobPoolEnqueueService $svc): int
    {
        // Eligible: not already sent, 48h satisfied, and (payment present OR special)
        $orders = Order::with(['items', 'invoice'])
            ->whereNull('sent_to_job_pool_at')
            ->get()
            ->filter(function ($order) use ($svc) {
                if (!$svc->editHoldSatisfied($order)) return false;
                $invoice = $order->invoice ?? \App\Models\Sales\Invoice::where('order_id', $order->id)->first();
                $hasPayment = $invoice ? $svc->paymentOnFile($invoice) : false;
                return $hasPayment || $invoice->is_special_customer;
            });

        $total = 0;
        foreach ($orders as $order) {
            $total += $svc->enqueueFromOrder($order);
        }

        $this->info("Released {$total} item(s) to Job Pool.");
        return self::SUCCESS;
    }
}
