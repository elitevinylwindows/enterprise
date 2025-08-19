<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sales\Quote;
use App\Models\Sales\Invoice;
use App\Services\JobPoolEnqueueService;

class ReleaseOrdersToJobPool extends Command
{
    protected $signature = 'orders:release-to-job-pool';
    protected $description = 'Auto-release eligible orders to Job Pool after 48h hold, per business rules';

    public function handle(JobPoolEnqueueService $svc): int
    {
        // Eligible: not already sent, 48h satisfied, and (payment present OR special)
        $quotes = Quote::with(['order', 'items', 'invoice'])
            ->whereNull('sent_to_job_pool_at')
            ->get()
            ->filter(function ($q) use ($svc) {
                if (!$svc->editHoldSatisfied($q)) return false;
                $invoice = $q->invoice ?? \App\Models\Sales\Invoice::where('quote_id', $q->id)->first();
                $hasPayment = $invoice ? $svc->paymentOnFile($invoice) : false;
                return $hasPayment || $q->is_special_customer;
            });

        $total = 0;
        foreach ($quotes as $q) {
            $total += $svc->enqueueFromQuote($q);
        }

        $this->info("Released {$total} item(s) to Job Pool.");
        return self::SUCCESS;
    }
}
