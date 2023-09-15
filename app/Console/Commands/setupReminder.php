<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Notification\SeasonalGreetingController;

class setupReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remind school admin to complete their setup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        SeasonalGreetingController::setupReminder();
    }
}
