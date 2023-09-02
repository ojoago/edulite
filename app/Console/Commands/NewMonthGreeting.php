<?php

namespace App\Console\Commands;

use App\Http\Controllers\Notification\SeasonalGreetingController;
use Illuminate\Console\Command;

class NewMonthGreeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newmonth:greeting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       SeasonalGreetingController::happyNewMonth();
    }
}
