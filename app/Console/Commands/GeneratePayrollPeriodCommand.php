<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use App\Jobs\PayrollPeriod\GenerateBiMonthlyJob;
use App\Jobs\PayrollPeriod\GenerateWeeklyJob;

class GeneratePayrollPeriodCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:payroll-period';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Payroll Period BMO & WKL';

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
        Bus::chain([
            new GenerateBiMonthlyJob,
            // new GenerateWeeklyJob,
        ])->dispatch();
    }
}
