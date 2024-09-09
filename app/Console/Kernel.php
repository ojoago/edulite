<?php

namespace App\Console;

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
    protected $commands = [
        Commands\SeasonalGreeting::class,
        Commands\BirthdayGreeting::class,
        Commands\NewMonthGreeting::class,
        Commands\setupReminder::class,
        Commands\XmasGreeting::class,
        Commands\ImportTables::class,
        Commands\CustomGreeting::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('seasonal:greeting')->everyMinute();
        $schedule->command('birthday:greeting')->daily()->runInBackground();
        $schedule->command('setup:reminder')->weekdays()->at('10:30')->runInBackground();
        $schedule->command('custom:greeting')->yearlyOn(9, 9, '12:55')->runInBackground();
        $schedule->command('newmonth:greeting')->monthly()->runInBackground();
        $schedule->command('seasonal:greeting')->yearlyOn(6, 12, '06:45')->runInBackground();
        // $schedule->command('seasonal:greeting')->yearlyOn(1, 1, '00:00')->runInBackground(); // happy new year
        $schedule->command('xmas:greeting')->yearlyOn(12, 25, '06:45')->runInBackground();
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
