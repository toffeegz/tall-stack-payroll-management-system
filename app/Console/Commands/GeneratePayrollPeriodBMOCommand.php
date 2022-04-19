<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PayrollPeriod;
use Carbon\Carbon;

class GeneratePayrollPeriodBMOCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:payroll-period-bmo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate payroll period bi-monthly every end date period';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Generate Payroll Period started successfully!');
        $payroll_period = PayrollPeriod::where('frequency_id', 1)->latest('period_end')->first();
        if($payroll_period)
        {
            if($payroll_period->cutoff_order == 2) 
            {
                $period_end =  Carbon::now()->day(10);
                if($period_end->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    $period_start =  Carbon::now()->subMonth()->day(26);
                    $payout_date = Carbon::now()->day(15);
                    $cutoff_order = 1;
                    $year = Carbon::now()->format('Y');
                    $this->insert($period_start, $period_end, $payout_date, $year, $cutoff_order);
                }
            } 
            elseif($payroll_period->cutoff_order == 1) 
            {
                $period_end =  Carbon::now()->day(25);
                if($period_end->format('Y-m-d') == Carbon::now()->format('Y-m-d')) {
                    $period_start =  Carbon::now()->day(11);
                    $payout_date = Carbon::now()->endOfMonth();       
                    $cutoff_order = 2;
                    $year = Carbon::now()->format('Y');
                    $this->insert($period_start, $period_end, $payout_date, $year, $cutoff_order);
                }
            }
        }

    }

    public function insert($period_start, $period_end, $payout_date, $year, $cutoff_order)
    {
        // Insert
        $data = PayrollPeriod::firstOrNew([
            'period_start' => $period_start,
            'period_end' => $period_end,
            'payout_date' => $payout_date,
            'year' => $year,
            'cutoff_order' => $cutoff_order,
        ]);
        $data->frequency_id = 1;
        $data->is_payroll_generated = false;
        $data->save();
    }
}
