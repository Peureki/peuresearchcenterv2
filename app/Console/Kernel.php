<?php

namespace App\Console;

use App\Jobs\ApiRefresh;
use App\Jobs\DailyReset;
use App\Jobs\Fetches\FetchNodeCombinations;
use App\Jobs\Fetches\FetchPrices;
use App\Jobs\Fetches\FetchRecipeValues;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new FetchPrices)->everyThirtyMinutes();
        $schedule->job(new FetchRecipeValues)->everySixHours();
        $schedule->job(new FetchNodeCombinations)->daily(); 

        // Refresh API stuff every 5 mins
        // $schedule->job(new ApiRefresh)->everyFiveMinutes();

        // Reset databases at reset
        $schedule->job(new DailyReset)->cron('0 0 * * *');
    }

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
}
