<?php

namespace App\Console;

use App\Jobs\ProcessAutoDepartures;
use App\Models\Log;
use App\Models\Visit;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ProcessAutoDepartures())
            ->everyMinute()
            ->onFailure(function () {
                Log::error('Auto departure job failed');
            });
    }


    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
