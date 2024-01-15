<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:tables';

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
        $state = public_path('files/tables/states.sql'); // write the sql filename here to import
        $lga = public_path('files/tables/state_lgas.sql'); // write the sql filename here to import
        DB::unprepared(file_get_contents($state));
        DB::unprepared(file_get_contents($lga));
        // return Command::SUCCESS;
    }
}
