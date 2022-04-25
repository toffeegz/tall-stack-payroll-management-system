<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PayrollPeriod;
use App\Jobs\GeneratePayrollPeriodWKLJob;
use Carbon\Carbon;

class GeneratePayrollPeriodWKLSeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:payroll-period-wkl-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate payroll period weekly every end date period';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generate Payroll Period started successfully!');
        $payroll_period = PayrollPeriod::where('frequency_id', 2)->latest('period_end')->first();
        
        if($payroll_period)
        {
            $period_end = Carbon::parse($payroll_period->period_end)->addDays(7);
            // if($period_end->format('Y-m-d') == Carbon::now()->format('Y-m-d')) 
            // {
                $period_start = Carbon::parse($payroll_period->period_start)->addDays(7);

                $period_end = (new Carbon($period_start))->addDays(6);
                $payout_date = (new Carbon($period_end))->addDays(2);

                $frequency_id = 2;

                if($payroll_period->cutoff_order == 4) {
                    $cutoff_order = 1;
                } else{
                    $cutoff_order = $payroll_period->cutoff_order + 1;
                }

                $year = $period_start->format('Y');

                if($period_start->format('Y') != $period_end->format('Y')) {
                    $year = $period_end->format('Y');
                }

                // insert
                $data = PayrollPeriod::firstOrNew([
                    'period_start' => $period_start->format('Y-m-d'),
                    'period_end' => $period_end->format('Y-m-d'),
                    'payout_date' => $payout_date->format('Y-m-d'),
                    'frequency_id' => $frequency_id,
                    'year' => $year,
                ]);
                $data->is_payroll_generated = false;
                $data->cutoff_order = $cutoff_order;
                $data->save();
            // }
        }
    }
}
