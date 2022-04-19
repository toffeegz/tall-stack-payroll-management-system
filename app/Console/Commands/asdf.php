<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PayrollPeriod;
use App\Jobs\GeneratePayrollPeriodWKLJob;
use Carbon\Carbon;

class GeneratePayrollPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Payroll Period';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generate Payroll Period started successfully!');
        $payroll_periods = PayrollPeriod::where('period_end', Carbon::now())->get();
        $this->info('Generate Payroll Period started successfully!');
        foreach($payroll_periods as $payroll_period) 
        {
            $this->info($payroll_period->period_end);
            if($payroll_period->frequency_id == 1) {
                GeneratePayrollPeriodBMOJob::dispatch();
            } 
            elseif($payroll_period->frequency_id == 2)  
            {
                $this->info('freq id 2');
                $period_end = Carbon::parse($payroll_period->period_end)->addDays(7);

                if($period_end == Carbon::now()) 
                {
                    $this->info('today');
                    GeneratePayrollPeriodWKLJob::dispatch();
                }
            }
        }
        
    }
}
