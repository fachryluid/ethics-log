<?php

namespace App\Console;

use App\Console\Commands\AutoForward;
use App\Console\Commands\ReportReminder;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(AutoForward::class)->hourly();
        $schedule->command(ReportReminder::class)->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
