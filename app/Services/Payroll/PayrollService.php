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
            'name' => $user->full_name,
            'total_hours' => [
                'regular' => 0,
                'late' => 0,
                'undertime' => 0,
                'overtime' => 0,
                'night_differential' => 0,
                'restday' => 0,
                'restday_ot' => 0
            ],
            'hours' => [],
        ];
    
        $date_range = $this->helper->getRangeBetweenDatesStr($period_start, $period_end);
    
        foreach ($date_range as $date) {
            $attendance = Attendance::where('user_id', $user->id)
                ->where('date', $date)
                ->whereNotIn('status', [4, 5])
                ->first();
    
            $collection['attendances'][$date] = $attendance ?? null;

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

                    $collection['hours'][$date] = $hours;
                } else {
                    // If no attendance, check if date is working day
                    $is_date_working_day = $this->helper->isDateWorkingDay(Carbon::parse($date));
                    if($is_date_working_day) {
                        // check if date is a holiday
                        $holiday = Holiday::where('date', $date)->first();
                        if ($holiday) {
                            // Handle holiday logic
                            // ...
                        } else {
                            // If not a holiday, check if it is a leave day
                            $leave = Leave::where('user_id', $user->id)
                                ->where('date', $date)
                                ->first();
                
                            if ($leave) {
                                // Handle leave logic
                                // ...
                            }
                        }
                    }
                }
            // 
            // Calculate total hours
                foreach ($collection['hours'] as $type => $hoursValue) {
                    $collection['total_hours'][$type] += $hoursValue;
                }
            //

            // Get the daily rate for the user on the specific date
                $designationUser = DesignationUser::where('user_id', $user->id)
                    ->where('created_at', '<=', $date)
                    ->orderBy('created_at', 'desc')
                    ->first();
        
                $collection['daily_rates'][$date] = $designationUser ? $designationUser->designation->daily_rate : null;
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