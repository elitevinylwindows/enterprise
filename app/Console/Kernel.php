<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


protected function schedule(Schedule $schedule): void
{
    // 1. Auto-generate purchases every 2 minutes
    $schedule->command('purchase:auto-generate')
        ->everyTwoMinutes();

    // 2. Run your closure job every minute with before/after hooks
    $schedule->call(function () {
        checkLastTransactionAndSendToJobPool();
    })
    ->cron('* * * * *')
    ->before(function () {
        Log::info('checkLastTransactionAndSendToJobPool function is about to run');
    })
    ->after(function () {
        Log::info('checkLastTransactionAndSendToJobPool function is executed');
    });

    // 3. Release orders to job pool every 5 minutes
    $schedule->command('orders:release-to-job-pool')
        ->everyFiveMinutes()
        ->before(function () {
            Log::info('Releasing orders to job pool is about to run');
        })
        ->after(function () {
            Log::info('Orders released to job pool successfully');
        });
}



}
