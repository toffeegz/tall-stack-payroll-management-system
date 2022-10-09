<?php

namespace App\Services\PayrollPeriod;

use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;
use App\Models\PayrollPeriod;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Helper;

class PayrollPeriodService implements PayrollPeriodServiceInterface
{
    private PayrollPeriodRepositoryInterface $modelRepository;

    public function __construct(
        PayrollPeriodRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function generateBiMonthly()
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . ' 00:00:00');
        $year = $now->format('Y');

        if(PayrollPeriod::all()->count() == 0) {
            $start_date = $now->copy()->subMonth();
            $cutoff_start = 1;
        } else {
            $previous_record = PayrollPeriod::latest('payout_date')->first();
            $start_date = Carbon::parse($previous_record->payout_date)->addMonth();
            $cutoff_start = $previous_record->cutoff_order == 2 ? 1:2;
        }

        $datePeriods = Helper::getRangeMonthBetweenDates($start_date->format('Y-m-d'), $now->format('Y-m-d'));
       
        $first_compare_date = Carbon::createFromFormat('Y-m-d H:i:s', $now->format('Y-m-') . '10 00:00:00');
        $last_compare_date = Carbon::createFromFormat('Y-m-d H:i:s', $now->format('Y-m-') . '25 00:00:00');
        $is_first = $now >= $first_compare_date ? true:false; 
        $is_last = $now >= $last_compare_date ? true:false; 

        $lists = [];
        foreach($datePeriods as $date) {
            echo $date->format('Y-m-d') . '/n';
            if($date->format('Y-m') == $now->format('Y-m')) {
                if($is_first == true) {
                    $lists[] = $this->bmCutoff(1, $date->format('Y'), $date->format('m'));
                } 
                if($is_last == true) {
                    $lists[] = $this->bmCutoff(2, $date->format('Y'), $date->format('m'));
                }
            } else {
                $lists[] = $this->bmCutoff(1, $date->format('Y'), $date->format('m'));
                $lists[] = $this->bmCutoff(2, $date->format('Y'), $date->format('m'));
            }
        }
        
    }

    public function bmCutoff($cutoff_order, $year, $month)
    {
        $month = new Carbon($year . "-" . $month . "-" . "01");
        switch($cutoff_order){
            case 1:
                $previous_month = $month->copy();
                $period_start = new Carbon($year . '-' . $previous_month->subMonth()->format('m') . "-" . "26");
                $period_end = new Carbon($year . '-' . $month->format('m') . "-" . "10");
                $payout_date = new Carbon($year . '-' . $month->format('m') . "-" . "15");
                break;
            case 2:
                $period_start = new Carbon($year . '-' . $month->format('m') . "-" . "11");
                $period_end = new Carbon($year . '-' . $month->format('m') . "-" . "25");
                $payout_date = $period_end->copy()->endOfMonth();
                break;
        }

        $params = [
            'frequency_id' => PayrollPeriod::FREQUENCY_BIMONTHLY,
            'year' => $year,
            'period_start' => $period_start->format('Y-m-d'),
            'period_end' => $period_end->format('Y-m-d'),
            'payout_date' => $payout_date->format('Y-m-d'),
            'cutoff_order' => $cutoff_order,
            'is_payroll_generated' => false,
        ];
        return $params;
    }

    public function store(array $params)
    {
        return $this->modelRepository->updateOrCreate([
            'frequency_id' => $params['frequency_id'],
            'year' => $params['year'],
            'period_start' => $params['period_start'],
            'period_end' => $params['period_end'],
        ], $params);
    }
    
}