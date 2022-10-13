<?php

namespace App\Jobs\PayrollPeriod;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;
use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\GeneratedPayrollPeriod;
use App\Models\PayrollPeriod;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Helper;

class GenerateBiMonthlyJob implements ShouldQueue
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
    private $modelService;
    private $modelRepository;
    public function handle(
        PayrollPeriodServiceInterface $modelService,
        PayrollPeriodRepositoryInterface $modelRepository,
    ) {
        $this->modelService = $modelService;
        $this->modelRepository = $modelRepository;
        Log::info('Generate Bi-Monthly Payroll Period started');
        $results = $this->generateBiMonthly();
        Log::info($results);
        Log::info('Generate Bi-Monthly Payroll Period ended');
    }

    public function generateBiMonthly()
    {
        $now = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d') . ' 00:00:00');
        $year = $now->format('Y');

        $previous_record = PayrollPeriod::whereDate('period_end', '<', Carbon::now())
        ->where('frequency_id', PayrollPeriod::FREQUENCY_BIMONTHLY)
        ->latest('period_end')
        ->first();

        if($previous_record) {
            $payout_date_previous_record = Carbon::parse($previous_record->payout_date);
            if($previous_record->cutoff_order == 1) {
                $payout_date = Carbon::createFromFormat('Y-m-d H:i:s', $payout_date_previous_record->copy()->endOfMonth()->format('Y-m-d') . ' 00:00:00');
            } elseif($previous_record->cutoff_order == 2) {
                $payout_date_previous_record = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::parse($previous_record->payout_date)->format('Y-m-') . '01 00:00:00');
                $payout_date = Carbon::createFromFormat('Y-m-d H:i:s', $payout_date_previous_record->copy()->addMonth()->format('Y-m-') . '15 00:00:00');
            }
            $cutoff_start = $previous_record->cutoff_order == 2 ? 1:2;

            $previous_record_period_end = Carbon::parse($previous_record->period_end);

            if($previous_record_period_end->format('Y-m') == $now->format('Y-m')) {
                if($previous_record->cutoff_order == 2) {
                    $cutoff_start = 0;
                } elseif($previous_record->cutoff_order == 1) {
                    if($now->format('d') < 25) {
                        $cutoff_start = 0;
                    }
                }
            } elseif($previous_record_period_end > Carbon::createFromFormat('Y-m-d H:i:s', $now->format('Y-m-') . $previous_record_period_end->format('d') . ' 00:00:00')) {
                $cutoff_start = 0;
            }
        } else {
            $payout_date = $now->copy()->subMonth();
            $payout_date = Carbon::createFromFormat('Y-m-d H:i:s', $now->copy()->subMonth()->format('Y-m-d') . ' 00:00:00');
            $cutoff_start = 1;
        }

        
        $rows = 0;
        $message = "Created Bi-Monthly Periods with a payout date:";

        if($cutoff_start != 0)
        {
            $cutoff_end = 0;
            
            if($now->format('d') >= 25) {
                $cutoff_end = 2;
            } elseif($now->format('d') >= 10) {
                $cutoff_end = 1;
            }

            $period_months = $this->bmMonthPeriods($payout_date, $now, $cutoff_start, $cutoff_end);
            $period_dates = [];
            foreach($period_months as $period)
            {
                $period_dates[] = $this->bmCutoff($period['cutoff_order'], $period['year'], $period['month']);
            }
            
            
            // store
            foreach($period_dates as $params)
            {
                $rows++;
                $reference_params = [
                    'frequency_id' => $params['frequency_id'],
                    'year' => $params['year'],
                    'period_start' => $params['period_start'],
                    'period_end' => $params['period_end'],
                ];
                $this->modelRepository->updateOrCreate($reference_params, $params);
                $message = $message . "," . $params['payout_date'];
            }
        }

        if($rows > 0) {
            $admins = Role::find(Role::ADMINISTRATOR_ID)->users;
            foreach($admins as $admin) {
                Mail::to($admin->email)->send(new GeneratedPayrollPeriod($message));
            }
            Log::info('Mail has been sent successfully to admins');
        }
        return "Created Bi-Monthly:" . $rows;
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

    public function bmCutoffArray($cutoff_order, $date)
    {
        return [
            'cutoff_order' => $cutoff_order,
            'year' => $date->format('Y'),
            'month' => $date->format('m'),
        ];
    }

    public function bmMonthPeriods($payout_date, $now, $cutoff_start, $cutoff_end)
    {
        $period_dates = [];
        $period_months = Helper::getRangeMonthBetweenDates($payout_date->format('Y-m-') . '01', $now->format('Y-m-d'));
        
        foreach($period_months as $month)
        {
            if($payout_date->format('Y-m') == $month->format('Y-m')) {
                if($cutoff_start == 1) {
                    $period_dates[] = $this->bmCutoffArray(1, $month);
                    $period_dates[] = $this->bmCutoffArray(2, $month);
                } elseif($cutoff_start == 2) {
                    $period_dates[] = $this->bmCutoffArray(2, $month);
                }
                
            } elseif($now->format('Y-m') == $month->format('Y-m')) {
                if($cutoff_end == 1) {
                    $period_dates[] = $this->bmCutoffArray(1, $month);
                } elseif($cutoff_end == 2) {
                    $period_dates[] = $this->bmCutoffArray(1, $month);
                    $period_dates[] = $this->bmCutoffArray(2, $month);
                }
            } else {
                $period_dates[] = $this->bmCutoffArray(1, $month);
                $period_dates[] = $this->bmCutoffArray(2, $month);
            }
        }

        return $period_dates;
    }
}
