<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SyncProductsOneS::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('quote:products')->dailyAt('00:01');
        $schedule->command('quote:risks')->dailyAt('00:06');
        $schedule->command('quote:objects')->dailyAt('00:11');
        $schedule->command('quote:types')->dailyAt('00:16');
        $schedule->command('items:activity-kinds')->dailyAt('00:21');
        $schedule->command('items:economy-sectors')->dailyAt('00:26');
        $schedule->command('items:countries')->dailyAt('00:30');
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
