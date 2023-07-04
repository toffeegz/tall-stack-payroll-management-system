<?php

namespace App\Services\Payroll;

use App\Repositories\Payslip\PayslipRepositoryInterface;
use App\Services\Payroll\PayrollServiceInterface;

use App\Models\User;
use App\Models\DesignationUser;
use App\Models\Payslip;
use App\Models\PayslipDeduction;
use App\Models\PayrollPeriod;
use App\Models\TaxContribution;
use App\Models\Loan;
use App\Models\LoanInstallment;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave;
use Carbon\Carbon;
use App\Helpers\Helper;

class PayrollService implements PayrollServiceInterface
{
    private PayslipRepositoryInterface $modelRepository;
    private $helper;

    public function __construct(
        PayslipRepositoryInterface $modelRepository,
        Helper $helper
    ) {
        $this->modelRepository = $modelRepository;
        $this->helper = $helper;
    }

    public function previewPayrollByUser($user, $period_start, $period_end)
    {
        $collection = [
            'user_id' => $user->id,
            'name' => $user->formal_name,
            'total_hours' => [
                'regular' => 0,
                'late' => 0,
                'undertime' => 0,
                'overtime' => 0,
                'night_differential' => 0,
                'restday' => 0,
                'restday_ot' => 0
            ]
        ];
    
        $date_range = $this->helper->getRangeBetweenDatesStr($period_start, $period_end);
    
        foreach ($date_range as $date) {
            
            $is_date_working_day = $this->helper->isDateWorkingDay(Carbon::parse($date));

            $collection['by_date'][$date]['hours'] = [
                'regular' => 0,
                'late' => 0,
                'undertime' => 0,
                'overtime' => 0,
                'night_differential' => 0,
                'restday' => 0,
                'restday_ot' => 0,
            ];
            $collection['by_date'][$date]['holiday']['is_holiday'] = FALSE;
            $collection['by_date'][$date]['holiday']['is_double_holiday'] = FALSE;
            $collection['by_date'][$date]['leave']['has_filed'] = FALSE;
            $collection['by_date'][$date]['leave']['record'] = [];

            // Get the daily rate for the user on the specific date
                $designationUser = DesignationUser::where('user_id', $user->id)
                    ->where('created_at', '<=', $date)
                    ->orderBy('created_at', 'desc')
                    ->first();

                $collection['by_date'][$date]['daily_rates'] = $designationUser ? $designationUser->designation->daily_rate : null;
            // 

            // GET ATTENDANCE 
                $attendance = Attendance::where('user_id', $user->id)
                    ->where('date', $date)
                    ->whereNotIn('status', [4, 5])
                    ->first();
        
                $collection['by_date'][$date]['attendance'] = $attendance ?? null;
            // 

            // GET HOLIDAY
                $holiday = Holiday::where('date', $date)->get();
                if($holiday->count() > 0) {
                    $collection['by_date'][$date]['holiday']['is_holiday'] = TRUE;
                    if($holiday->count() > 1) {
                        $collection['by_date'][$date]['holiday']['is_double_holiday'] = TRUE;
                    }
                    $collection['by_date'][$date]['holiday']['records'] = $holiday;
                }
            // 

            // GET LEAVE
                $leave = Leave::where('user_id', $user->id)
                    ->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date)
                    ->where('status', 2) // Assuming status 2 indicates approved leave
                    ->first();

                if ($leave) {
                    $collection['by_date'][$date]['leave']['has_filed'] = TRUE;
                    $collection['by_date'][$date]['leave']['record'] = $leave;
                }
            //

            // get regular, late, undertime, overtime, night_differential, restday, restday_ot in attendance
                if ($attendance) {
                    $hours = [
                        'regular' => $attendance->status === 1 || $attendance->status === 2 ? $attendance->regular : 0,
                        'late' => $attendance->status === 1 || $attendance->status === 2 ? $attendance->late : 0,
                        'undertime' => $attendance->status === 1 || $attendance->status === 2 ? $attendance->undertime : 0,
                        'overtime' => $attendance->status === 1 || $attendance->status === 2 ? $attendance->overtime : 0,
                        'night_differential' => $attendance->night_differential,
                        'restday' => $attendance->status === 3 ? $attendance->regular : 0,
                        'restday_ot' => $attendance->status === 3 ? $attendance->overtime : 0,
                    ];

                    $collection['by_date'][$date]['hours'] = $hours;
                } 
            // 

            // Calculate total hours
                if(isset($collection['by_date'][$date]['hours'])) {
                    foreach ($collection['by_date'][$date]['hours'] as $type => $hoursValue) {
                        $collection['total_hours'][$type] += $hoursValue;
                    }
                }
            //
        }
    
        // Generate the rates_range array
            $designationUser = DesignationUser::where('user_id', $user->id)
                ->where('created_at', '<=', $period_end)
                ->orderBy('created_at')
                ->get();

            $ratesRange = [];
            $previousTo = null;

            foreach ($designationUser as $key => $du) {
                $from = ($key === 0) ? $period_start : $previousTo;
                $to = ($key + 1 < count($designationUser)) ? $designationUser[$key + 1]->created_at->subDay()->format('Y-m-d') : $period_end;

                $rate = $du->designation->daily_rate;

                $ratesRange[] = [
                    'from' => $from,
                    'to' => $to,
                    'rate' => $rate,
                ];

                $previousTo = $to;
            }

            $collection['rates_range'] = $ratesRange;
        //

        return $collection;
    }
    


}