<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Notification\SeasonalGreetingController;

class SeasonalGreeting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seasonal:greeting';

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
        SeasonalGreetingController::seasonalGreeting();
    }
}
