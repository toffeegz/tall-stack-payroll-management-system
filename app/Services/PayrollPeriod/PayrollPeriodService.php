<?php

namespace App\Services\PayrollPeriod;

use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;
use App\Models\PayrollPeriod;
use Carbon\Carbon;

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
        $now = Carbon::now();
        $year = $now->format('Y');

        if(PayrollPeriod::all()->count() == 0) {
            $start_month = $now->copy()->subMonth()->format('m');
            $cutoff_start = 1;
        } else {
            $previous_record = PayrollPeriod::latest('payout_date')->first();
            $start_month = Carbon::parse($previous_record->payout_date)->addMonth()->format('m');
            $cutoff_start = $previous_record->cutoff_order == 2 ? 1:2;
        }

        return $cutoff_start;

        // $result = $this->bmCutoff($cutoff_order = 1, $year, $month);
        // $result = $this->bmCutoff($cutoff_order = 2, $year, $month);
        return "success";
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

        $result = $this->store($params);
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