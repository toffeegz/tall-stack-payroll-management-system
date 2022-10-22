<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Bus;
use App\Jobs\EmployeeCutoff\BiMonthlySeederJob;
use App\Jobs\EmployeeCutoff\BiWeeklySeederJob;
use Illuminate\Support\Facades\Log;

class GenerateEmployeeCutoffCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:employee-cutoff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Employee Cut-off';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('Generate Employee Cut-off Command started');
        Bus::chain([
            new BiMonthlySeederJob,
            // new BiWeeklySeederJob,
        ])->dispatch();
        Log::info('Generate Employee Cut-off Command ended');
    }
}
