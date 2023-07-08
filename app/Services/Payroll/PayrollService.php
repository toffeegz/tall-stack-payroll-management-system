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
use App\Models\Earning;
use App\Models\Deduction;
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
            'code' => $user->code,
            'total_hours' => [
                'regular' => [
                    'name' => 'Regular',
                    'acronym' => 'rg',
                    'value' => 0,
                    'visible' => FALSE,
                    'is_editable' => false,
                ],
                'late' => [
                    'name' => 'Late',
                    'acronym' => 'lt',
                    'value' => 0,
                    'visible' => FALSE,
                    'is_editable' => false,
                ],
                'undertime' => [
                    'name' => 'Undertime',
                    'acronym' => 'ut',
                    'value' => 0,
                    'visible' => FALSE,
                    'is_editable' => false,
                ],
                'overtime' => [
                    'name' => 'Overtime',
                    'acronym' => 'ot',
                    'value' => 0,
                    'visible' => FALSE,
                    'is_editable' => false,
                ],
                'night_differential' => [
                    'name' => 'Night Diff',
                    'acronym' => 'nd',
                    'value' => 0,
                    'visible' => FALSE,
                    'is_editable' => false,
                ],
                'restday' => [
                    'name' => 'Rest Day',
                    'acronym' => 'rd',
                    'value' => 0,
                    'visible' => FALSE,
                    'is_editable' => false,
                ],
                'restday_ot' => [
                    'name' => 'Rest Day OT',
                    'acronym' => 'rdot',
                    'value' => 0,
                    'visible' => FALSE,
                    'is_editable' => false,
                ],
            ],
            'deductions' => [],
            'additional_earnings' => [],
            'include_in_payroll' => true,
            'is_visible' => true
        ];

        // additional earnings initial
        $earning_types = Earning::where('active', true)->get();
            foreach($earning_types as $earning_type)
            {
                $collection['additional_earnings'][$earning_type->id] = [
                    'name' => $earning_type->name,
                    'acronym' => $earning_type->acronym,
                    'amount' => null,
                    'visible' => false,
                ];
            }
        // 

        // additional deductions initial
        $deduction_types = Deduction::where('active', true)->get();
            foreach($deduction_types as $deduction_type)
            {
                $collection['deductions'][$deduction_type->id] = [
                    'name' => $deduction_type->name,
                    'acronym' => $deduction_type->acronym,
                    'amount' => null,
                    'visible' => false,
                ];
            }
        // 
    
        $date_range = $this->helper->getRangeBetweenDatesStr($period_start, $period_end);
        $tardiness = 0;
    
        foreach ($date_range as $date) {
            
            $is_date_working_day = $this->helper->isDateWorkingDay(Carbon::parse($date));
            $collection['by_date'][$date]['is_working_day'] = $is_date_working_day;

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
                $hourly_rate = $collection['by_date'][$date]['daily_rates'] / 8;
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

            // GET HOURS
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

            // GET TARDINESS
            // get deductions late / undertime
                if($collection['by_date'][$date]['hours']['late'] > 0 || $collection['by_date'][$date]['hours']['undertime'] > 0) {
                    $late_hour = $collection['by_date'][$date]['hours']['late'];
                    $undertime_hour = $collection['by_date'][$date]['hours']['undertime'];
                    $late_amount = $late_hour * $hourly_rate;
                    $undertime_amount = $undertime_hour * $hourly_rate;
                    $tardiness_date = ($late_amount + $undertime_amount);
                    $tardiness += $tardiness_date;
                    $collection['by_date'][$date]['tardiness'] = $tardiness_date;
                }
            // 

            // Calculate total hours
                if(isset($collection['by_date'][$date]['hours'])) {
                    foreach ($collection['by_date'][$date]['hours'] as $type => $hoursValue) {
                        if($hoursValue !== 0) {
                            $collection['total_hours'][$type]['visible'] = TRUE;
                        } 
                        $collection['total_hours'][$type]['value'] += $hoursValue;
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
                    'rate' => strval(number_format($rate, 2, '.', ',')) . "\u{00A0}",
                ];

                $previousTo = $to;
            }

            $collection['rates_range'] = $ratesRange;
            if(count($ratesRange) === 0) {
                $collection['is_visible'] = false;
                $collection['include_in_payroll'] = false;
            }
            
        //

        // cash advance
            $loan = Helper::getCashAdvanceAmountToPay($user->id);
            if($loan > 0) {
                $collection['deductions']['loan'] = [
                    'name' => 'Loan',
                    'acronym' => 'lo',
                    'amount' => $loan,
                    'visible' => true,
                    'is_editable' => false,
                ];
            }
        // 

        // tardiness
            if($tardiness > 0) {
                $collection['deductions']['tardiness'] = [
                    'name' => 'Tardiness',
                    'acronym' => 'td',
                    'amount' => $tardiness,
                    'visible' => true,
                    'is_editable' => false,
                ];
            }
        // 

        // is total hours valid
            $total_hours = 0;
            foreach($collection['total_hours'] as $type => $data_total_hours) {
                $type = $type;
                if($type === 'regular' || $type === 'overtime' || $type === 'night_differential'  || $type  === 'restday' || $type === 'restday_ot') {
                    $total_hours += $data_total_hours['value'];
                }
            }
            if($total_hours === 0) {
                $collection['include_in_payroll'] = false;
                $collection['is_visible'] = false;
            }
            
        // 


        return $collection;
    }
    


}