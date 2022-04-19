<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\PayrollPeriod;
use Carbon\Carbon;

class TempPayrollPeriodGeneratorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $period_start = Carbon::parse('2020-12-24');
        $frequency_id = 2;

        for($i=1; $i<=4; $i++)
        {
            $period_start = (new Carbon($period_start))->addDays(7);
            $period_end = (new Carbon($period_start))->addDays(6);
            $payout_date = (new Carbon($period_end))->addDays(3);

            $year = Carbon::now()->format('Y');
            $cutoff_order = $i;
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

            if($i == 4) {
                $i = 0;
            }

            if($period_start == Carbon::parse('2021-11-11')) {
                break;
            }
        }
    }
}
