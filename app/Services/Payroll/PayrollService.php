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
use App\Models\SssContributionRate;
use App\Models\SssContributionModel;
use App\Models\HdmfContributionRate;
use App\Models\PhicContributionRate;
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
            'is_visible' => true,
            'tardiness_collection' => [
                'late' => 0,
                'undertime' => 0,
                'absences' => 0,
            ]
        ];

        // INITIAL: ADDITIONAl EARNINGS
            $earning_types = Earning::where('active', true)->get();
            foreach($earning_types as $earning_type)
            {
                $collection['additional_earnings'][$earning_type->id] = [
                    'name' => $earning_type->name,
                    'acronym' => $earning_type->acronym,
                    'amount' => null,
                    'visible' => false,
                    'is_taxable' => $earning_type->is_taxable,
                ];
            }
        // 

        // INITIAL: ADDITIONAL DEDUCTIONS
            $deduction_types = Deduction::where('active', true)->get();
            foreach($deduction_types as $deduction_type)
            {
                $collection['deductions'][$deduction_type->id] = [
                    'name' => $deduction_type->name,
                    'acronym' => $deduction_type->acronym,
                    'amount' => null,
                    'visible' => false,
                    'is_editable' => true
                ];
            }
        // 
    
        $date_range = $this->helper->getRangeBetweenDatesStr($period_start, $period_end);
        $tardiness = 0;
        $basic_pay = 0;
        $earnings = 0;
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

            // GET THE DAILY RATE FOR THE USER ON THE SPECIFIC DATE
                $designationUser = DesignationUser::where('user_id', $user->id)
                    ->where('created_at', '<=', $date)
                    ->orderBy('created_at', 'desc')
                    ->first();
                $daily_rate_user = $designationUser ? $designationUser->designation->daily_rate : null;
                $collection['by_date'][$date]['daily_rates'] = $daily_rate_user;
                $hourly_rate = $collection['by_date'][$date]['daily_rates'] / 8;
                $collection['by_date'][$date]['hourly_rate'] = $hourly_rate;
            // 

            // BASIC PAY 
                if($is_date_working_day === true) {
                    $basic_pay += $daily_rate_user;
                }
            // 

            // GET ATTENDANCE 
                $is_present = false;
                $attendance = Attendance::where('user_id', $user->id)
                    ->where('date', $date)
                    ->whereNotIn('status', [4, 5])
                    ->first();
                $is_present = $attendance ? true : false;
                $collection['by_date'][$date]['attendance'] = $attendance ?? null;
                $collection['by_date'][$date]['is_present'] = $is_present;
            // 

            // GET HOLIDAY
                $holiday = Holiday::where('date', $date)->get();
                $is_holiday = FALSE;
                if($holiday->count() > 0) {
                    $is_holiday = TRUE;
                    $collection['by_date'][$date]['holiday']['is_holiday'] = TRUE;
                    if($holiday->count() > 1) {
                        $collection['by_date'][$date]['holiday']['is_double_holiday'] = TRUE;
                    }
                    $collection['by_date'][$date]['holiday']['records'] = $holiday;
                }
            // 

            // GET LEAVE
                $has_filed = false;
                $leave = Leave::where('user_id', $user->id)
                    ->where('start_date', '<=', $date)
                    ->where('end_date', '>=', $date)
                    ->where('status', 2) // Assuming status 2 indicates approved leave
                    ->first();

                if ($leave) {
                    $has_filed = TRUE;
                    $collection['by_date'][$date]['leave']['has_filed'] = $has_filed;
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

                    $collection['by_date'][$date]['tardiness_collection']['late'] = $late_amount;
                    $collection['by_date'][$date]['tardiness_collection']['undertime'] = $undertime_amount;

                    $collection['tardiness_collection']['late'] += $late_amount;
                    $collection['tardiness_collection']['undertime'] += $undertime_amount;
                }
                if($is_present === false && $has_filed === false && $is_date_working_day === true && $is_holiday === false) {
                    $tardiness += $daily_rate_user;
                    $collection['tardiness_collection']['absences'] += $daily_rate_user;
                }
            // 

            // CALCULATE TOTAL HOURS
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
    
        // RATES RANGE
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

                $previousTo = Carbon::parse($to)->addDay()->format('Y-m-d');
            }

            $collection['rates_range'] = $ratesRange;
            if(count($ratesRange) === 0) {
                $collection['is_visible'] = false;
                $collection['include_in_payroll'] = false;
            }
            
        //

        // CASH ADVANCE
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

        // TARDINESS
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

        // TOTAL HOURS VALID
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

        $collection['basic_pay'] = $basic_pay;
        $collection['earnings'] = $earnings;
        return $collection;
    }
    
    public function payroll($data)
    {
        $raw_collection = (json_decode($data->data,true));
        $collection = [];

        foreach($raw_collection as $user_id => $user_collection)
        {
            $payroll_period = PayrollPeriod::where('period_start', $data->period_start)
                ->where('period_end', $data->period_end)
                ->first();

            $user = User::find($user_id);
            $new_collection =  [
                'user_id' => $user_collection['user_id'], //
                'full_name' => $user_collection['name'],
                'code' => $user_collection['code'],
                'rates_range' => $user_collection['rates_range'],
                'payroll_period_id' => $payroll_period->id,
                // 'earnings' => $user_collection['earnings'],
                'preview_data' => $user_collection,
                'additional_earnings' => []
            ];
            foreach($user_collection['total_hours'] as $hour_type => $hours) {
                $new_collection[$hour_type] = $hours['value'];
            }
            $earnings = 0;
            $earnings_by_hours = 0;
            $holiday_pay = 0;
            $leave_pay = 0;
            $overtime_pay = 0;
            $restday_pay = 0;
            $restday_ot_pay = 0;
            $night_differential_pay = 0;

            $new_collection['holidays_collection'] = [
                'regular' => 0,
                'overtime' => 0,
                'restday' => 0,
                'restday_ot' => 0,
                'legal' => 0,
                'legal_ot' => 0,
                'special' => 0,
                'special_ot' => 0,
                'double'  => 0,
                'double_ot'  => 0,
            ];
            // BY DATE
                foreach($user_collection['by_date'] as $date => $by_date) {
                    $new_collection['by_date'][$date] = $by_date;
                    $hours = $by_date['hours'];
                    $hourly_rate = $by_date['hourly_rate'];
                    $is_working_day = $by_date['is_working_day'];

                    if($by_date['is_present'] === true) {
                        // regular
                            $overtime = $hours['overtime'] * $hourly_rate * 1.25;
                            $restday = $hours['restday'] * $hourly_rate  * 1.30;
                            $restday_ot = $hours['restday_ot'] * $hourly_rate  * 1.69;
                            $night_differential = $hours['night_differential'] * $hourly_rate  * .10;
                            $earnings_regular = [
                                'regular' => $hours['regular'] * $hourly_rate,
                                'overtime' => $overtime,
                                'restday' => $restday,
                                'restday_ot' => $restday_ot,
                                'night_differential' => $night_differential,
                            ];
                            $new_collection['by_date'][$date]['earnings']['regular'] = $earnings_regular;
                            foreach($earnings_regular as $hour_type => $earning_amount) {
                                $earnings_by_hours += $earning_amount;
                            }

                            $overtime_pay += $overtime;
                            $restday_pay += $restday;
                            $restday_ot_pay += $restday_ot;
                            $night_differential_pay += $night_differential;
                        // 

                        // holiday
                            if($user->is_paid_holidays === 1) {
                                $is_holiday = $by_date['holiday']['is_holiday'];
                                $is_double_holiday = $by_date['holiday']['is_double_holiday'];
                                $holiday_amounts = [
                                    'regular' => 0,
                                    'overtime' => 0,
                                    'restday' => 0,
                                    'restday_ot' => 0,
                                ];
                                if($is_holiday === true) {
                                    if($is_double_holiday === true) {
                                        $holiday_percentage = config('company.holiday_percentage.double');
                                        $new_collection['by_date'][$date]['holiday']['type'] = 'double';
                                    } else {
                                        $holiday_record = $by_date['holiday']['records'][0];
                                        if($holiday_record['is_legal'] === 1) {
                                            $holiday_percentage = config('company.holiday_percentage.legal');
                                        $new_collection['by_date'][$date]['holiday']['type'] = 'legal';
                                        } else {
                                            $holiday_percentage = config('company.holiday_percentage.special');
                                        $new_collection['by_date'][$date]['holiday']['type'] = 'special';
                                        }
                                    }
                                    foreach($holiday_percentage as $hour_type => $percentage) {
                                        $holiday_amount = $hours[$hour_type] * $hourly_rate * $percentage;
                                        $holiday_amounts[$hour_type] = $holiday_amount;
                                        $holiday_pay += $holiday_amount;
                                        $new_collection['holidays_collection'][$hour_type] += $holiday_amount;
                                        
                                        if($new_collection['by_date'][$date]['holiday']['type'] === 'double') {
                                            if($hour_type === 'regular' || $hour_type === 'restday') {
                                                $new_collection['holidays_collection']['double'] += $holiday_amount;
                                            } else {
                                                $new_collection['holidays_collection']['double_ot'] += $holiday_amount;
                                            }
                                        } elseif($new_collection['by_date'][$date]['holiday']['type'] === 'legal') {
                                            if($hour_type === 'regular' || $hour_type === 'restday') {
                                                $new_collection['holidays_collection']['legal'] += $holiday_amount;
                                            } else {
                                                $new_collection['holidays_collection']['legal_ot'] += $holiday_amount;
                                            }
                                        } elseif($new_collection['by_date'][$date]['holiday']['type'] === 'special') {
                                            if($hour_type === 'regular' || $hour_type === 'restday') {
                                                $new_collection['holidays_collection']['special'] += $holiday_amount;
                                            } else {
                                                $new_collection['holidays_collection']['special_ot'] += $holiday_amount;
                                            }
                                        }
                                    }
                                    $new_collection['by_date'][$date]['holiday']['amount'] = $holiday_amounts;
                                }
                            }
                        // 
                    } 
                    if($by_date['leave']['has_filed'] === true && $by_date['leave']['record']['is_paid'] === 1 && $is_working_day === true) {
                        if($by_date['leave']['record']['type_id'] === 2) { // half day 
                            $leave_hours = 4;
                        } else {
                            $leave_hours = 8;
                        }
                        $leave_amount = $leave_hours * $hourly_rate;
                        $leave_pay += $leave_amount;
                        $new_collection['by_date'][$date]['leave']['hours'] = $leave_hours;
                        $new_collection['by_date'][$date]['leave']['amount'] = $leave_amount;
                    }

                    if($is_working_day === true) {
                        $earnings += $by_date['daily_rates'];
                    }

                }
            // 

            // ADDITIONAL EARNINGS, TAXABLE, NONTAXABLE
                $taxable_earnings = 0;
                $non_taxable_earnings = 0;
                $additional_earnings = 0;
                foreach($user_collection['additional_earnings'] as $raw_additional_earning)
                {
                    $amount = $raw_additional_earning['amount'];
                    if($amount > 0) {
                        $additional_earnings += $amount;
                        $additional_earning_name = $raw_additional_earning['name'];
                        $new_collection['earning_collections']['additional_earnings'][$additional_earning_name] = $amount;
                        if($raw_additional_earning['is_taxable'] === 1) {
                            $taxable_earnings += $amount;
                        } else {
                            $non_taxable_earnings += $amount;
                        }
                    }
                }
            // 

            // ADDITIONAL DEDUCTIONS
                $total_deductions = 0;
                foreach($user_collection['deductions'] as $raw_additional_deduction)
                {
                    $additional_deduction_amount = $raw_additional_deduction['amount'];
                    $additional_deduction_name = $raw_additional_deduction['name'];

                    if($additional_deduction_amount > 0 && $additional_deduction_name != 'Tardiness') {
                        $total_deductions += $additional_deduction_amount;
                        $new_collection['deductions_collection'][$additional_deduction_name] = $additional_deduction_amount;
                        $total_deductions += $additional_deduction_amount;
                    }
                }
                if($user_collection['tardiness_collection']['late'] > 0) {
                    $new_collection['deductions_collection']['late'] = $user_collection['tardiness_collection']['late'];
                    $total_deductions += $user_collection['tardiness_collection']['late'];;
                }

                if($user_collection['tardiness_collection']['undertime'] > 0) {
                    $new_collection['deductions_collection']['undertime'] = $user_collection['tardiness_collection']['undertime'];
                    $total_deductions += $user_collection['tardiness_collection']['undertime'];;
                }

                if($user_collection['tardiness_collection']['absences'] > 0) {
                    $new_collection['deductions_collection']['absences'] = $user_collection['tardiness_collection']['absences'];
                    $total_deductions += $user_collection['tardiness_collection']['absences'];;
                }
                
            // 

            // TAX CONTRIBUTION
                $tax_contributions = 0;
                if($user->is_tax_exempted == false)
                {
                    $cutoff_order = 2;

                    for($i = 1; $i <= $cutoff_order; $i++)
                    {
                        $limit[] = $i;
                    }

                    // GET PREVIOUS PAYROLL PERIOD TO GET LATEST PAYSLIP 

                        $previous_payroll_period = PayrollPeriod::where('frequency_id', $payroll_period->frequency_id)
                        ->whereDate('period_end', '<', $payroll_period->period_end)
                        ->latest('period_end')
                        ->first();

                        $latest_payslip = null;

                        if($previous_payroll_period)
                        {
                            // get payslip
                            $latest_payslip = Payslip::where('user_id', $user->id)
                            ->where('payroll_period_id', $previous_payroll_period->id)
                            ->first();

                        }

                        // CUTOFF ORDER
                            $cutoff_order = 1;

                            // BMO
                            if($user->frequency_id == 1)
                            {

                                $cutoff_order = 2;
                                
                                if($latest_payslip)
                                {
                                    $last_cutoff_order = $latest_payslip->cutoff_order;
                                    if($latest_payslip->cutoff_order == 2)
                                    {
                                        $cutoff_order = 1;
                                    }
                                }
                            }

                            // WKL
                            if($user->frequency_id == 2)
                            {
                                if($latest_payslip)
                                {
                                    if($latest_payslip->cutoff_order == 4)
                                    {
                                        $cutoff_order = 1;
                                    } else {
                                        $cutoff_order = $latest_payslip->cutoff_order + 1;
                                    }
                                }

                            }
                        // 
                    // ///// 

                    if($cutoff_order == 1){
                        $salary = $taxable_earnings;
                    } else {
                        if($cutoff_order == 2)
                        {   
                            $payroll_period_ids[] = $previous_payroll_period->id;
                        }
                        elseif($cutoff_order == 3 || $cutoff_order == 4)
                        {   
                            $payroll_period_records = PayrollPeriod::where('frequency_id', $payroll_period->frequency_id)
                            ->whereDate('period_end', '<', $payroll_period->period_end)
                            ->latest('period_end')
                            ->limit($cutoff_order - 1)
                            ->pluck('id');

                            $payroll_period_ids[] = $payroll_period_records;
                        }
                        
                        $previous_payslips = Payslip::where('user_id', $user->id)
                        ->whereIn('payroll_period_id', $payroll_period_ids)
                        ->get();

                        $salary = $taxable_earnings + $previous_payslips->sum('taxable');
                    }

                    $tax_divide = 2;
                    if($user->frequency_id == 2)
                    {
                        $tax_divide = 4;
                    }

                    // SSS CONTRIBUTION (TYPE 1)
                        $sss_monthly_tax_contribution = $this->getSSSContributionAmount($salary);

                        $sss_er_to_pay = $sss_monthly_tax_contribution['er'];
                        $sss_ee_to_pay = $sss_monthly_tax_contribution['ee'];
                        $sss_ec_to_pay = $sss_monthly_tax_contribution['ec'] / $tax_divide;

                        if($cutoff_order != 1)
                        {
                            $paid_tax_sss = TaxContribution::where('user_id', $user_id)
                            ->where('tax_type', 1)
                            ->whereIn('payroll_period_id', $payroll_period_ids)
                            ->get();
                            $sss_er_paid = $paid_tax_sss->sum('employer_share');
                            $sss_ee_paid = $paid_tax_sss->sum('employee_share');

                            $sss_er_to_pay = $sss_monthly_tax_contribution['er'] - $sss_er_paid;
                            $sss_ee_to_pay = $sss_monthly_tax_contribution['ee'] - $sss_ee_paid;
                        } 
                        $new_collection['deductions_collection']['tax_contribution']['sss_contribution'] = [
                            'er' => $sss_er_to_pay,
                            'ee' => $sss_ee_to_pay,
                            'ec' => $sss_ec_to_pay,
                        ];

                        $tax_contributions += $sss_ee_to_pay;

                    // 

                    // HDMF CONTRIBUTION (TYPE 2)
                        $hdmf_monthly_tax_contribution = $this->getHDMFContributionAmount($user_collection['rates_range'], $data->period_start, $data->period_end);
                        $hdmf_monthly_er_to_pay = $hdmf_monthly_tax_contribution['er'];
                        $hdmf_monthly_ee_to_pay = $hdmf_monthly_tax_contribution['ee'];

                        $hdmf_er_to_pay = $hdmf_monthly_tax_contribution['er'] / $tax_divide;
                        $hdmf_ee_to_pay = $hdmf_monthly_tax_contribution['ee'] / $tax_divide;
                        
                        $balance_ee = 0;
                        $balance_er = 0;

                        if($cutoff_order != 1)
                        {
                            $paid_tax_hdmf = TaxContribution::where('user_id', $user_id)
                            ->where('tax_type', 2)
                            ->whereIn('payroll_period_id', $payroll_period_ids)
                            ->get();

                            $hdmf_er_paid = $paid_tax_hdmf->sum('employer_share');
                            $hdmf_ee_paid = $paid_tax_hdmf->sum('employee_share');

                        
                            $amount_should_be_paid_er = ($cutoff_order - 1) * $hdmf_er_to_pay;
                            $amount_should_be_paid_ee = ($cutoff_order - 1) * $hdmf_ee_to_pay;

                            $balance_ee = $amount_should_be_paid_ee - $hdmf_ee_paid;
                            $balance_er = $amount_should_be_paid_er - $hdmf_er_paid;
                        } 

                        $hdmf_total_ee = $balance_ee + $hdmf_ee_to_pay;
                        $hdmf_total_er = $balance_er + $hdmf_er_to_pay;

                        $new_collection['deductions_collection']['tax_contribution']['hdmf_contribution'] = [
                            'total_ee' => $hdmf_total_ee,
                            'total_er' => $hdmf_total_er,
                            'current_ee' => $hdmf_ee_to_pay,
                            'current_er' => $hdmf_er_to_pay,
                            'balance_from_previous_ee' => $balance_ee,
                            'balance_from_previous_er' => $balance_er,
                            'month_ee' => $hdmf_monthly_ee_to_pay,
                            'month_er' => $hdmf_monthly_er_to_pay,
                        ];
                        $tax_contributions += $hdmf_total_ee;


                    // 
                
                    // PHIC CONTRIBUTION (TYPE 3)
                        $phic_monthly_tax_contribution = $this->getPHICContributionAmount($user_collection['rates_range'], $data->period_start, $data->period_end);
                        $phic_monthly_er_to_pay = $phic_monthly_tax_contribution['er'];
                        $phic_monthly_ee_to_pay = $phic_monthly_tax_contribution['ee'];

                        $phic_er_to_pay = $phic_monthly_tax_contribution['er'] / $tax_divide;
                        $phic_ee_to_pay = $phic_monthly_tax_contribution['ee'] / $tax_divide;
                        
                        $balance_ee = 0;
                        $balance_er = 0;

                        if($cutoff_order != 1)
                        {
                            $paid_tax_phic = TaxContribution::where('user_id', $user_id)
                            ->where('tax_type', 3)
                            ->whereIn('payroll_period_id', $payroll_period_ids)
                            ->get();

                            $phic_er_paid = $paid_tax_hdmf->sum('employer_share');
                            $phic_ee_paid = $paid_tax_hdmf->sum('employee_share');

                        
                            $amount_should_be_paid_er = ($cutoff_order - 1) * $phic_er_to_pay;
                            $amount_should_be_paid_ee = ($cutoff_order - 1) * $phic_ee_to_pay;

                            $balance_ee = $amount_should_be_paid_ee - $hdmf_ee_paid;
                            $balance_er = $amount_should_be_paid_er - $hdmf_er_paid;
                        } 
                        
                        $phic_total_ee = $balance_ee + $phic_ee_to_pay;
                        $phic_total_er = $balance_er + $phic_er_to_pay;

                        $new_collection['deductions_collection']['tax_contribution']['phic_contribution'] = [
                            'total_ee' => $phic_total_ee,
                            'total_er' => $phic_total_er,
                            'current_ee' => $phic_ee_to_pay,
                            'current_er' => $phic_er_to_pay,
                            'balance_from_previous_ee' => $balance_ee,
                            'balance_from_previous_er' => $balance_er,
                            'month_ee' => $phic_monthly_ee_to_pay,
                            'month_er' => $phic_monthly_er_to_pay,
                        ];
                        $tax_contributions += $phic_total_ee;
                        
                    // 
                } else {
                    $cutoff_order = $payroll_period->cutoff_order;
                }
                
            // 
            
            // GROSS PAY AND TOTAL TAXABLE AND NET PAY
                $total_deductions += $tax_contributions;
                $taxable = $earnings + $holiday_pay + $taxable_earnings + $leave_pay;
                $gross_pay = $taxable + $non_taxable_earnings;
                $net_pay = $gross_pay - $total_deductions;
            // 

            $new_collection['basic_pay'] = $earnings;
            $new_collection['earnings_by_hours'] = $earnings_by_hours;
            $new_collection['holiday_pay'] = $holiday_pay;
            $new_collection['leave_pay'] = $leave_pay;
            $new_collection['gross_pay'] = $gross_pay;
            $new_collection['taxable'] = $taxable;
            $new_collection['non_taxable'] = $non_taxable_earnings;
            $new_collection['taxable_earnings'] = $taxable_earnings;
            $new_collection['total_deductions'] = $total_deductions;
            $new_collection['tax_contributions'] = $tax_contributions;
            $new_collection['net_pay'] = $net_pay;
            $new_collection['cutoff_order'] = $cutoff_order;
            $new_collection['is_tax_exempted'] = $user->is_tax_exempted;
            $new_collection['earning_collections']['overtime'] = $overtime_pay;
            $new_collection['earning_collections']['restday'] = $restday_pay;
            $new_collection['earning_collections']['restday_ot'] = $restday_ot_pay;
            $new_collection['earning_collections']['night_differential'] = $night_differential_pay;
            // dd($new_collection);
            // $user_array =  [
                // 'user_id' => $user_id, //
                // 'cutoff_order' => $cutoff_order,
                // 'payroll_period_id' => $payroll_period->id,
                // 'full_name' => $user->formal_name(), // 
                // 'daily_rate' => $daily_rate, //

                // 'regular' => $regular_hours, //
                // 'overtime' => $overtime_hours, //
                // 'restday' => $restday_hours, //
                // 'restday_ot' => $restday_ot_hours, //
                // 'night_differential' => $night_diff_hours, //
                // 'late' => $late_hours, //
                // 'undertime' => $undertime_hours, //
                
                // 'basic_pay' => $basic_pay,
                // 'gross_pay' => $gross_pay,
                // 'net_pay' => $net_pay,

                // 'is_tax_exempted' => $user->is_tax_exempted,
                // 'tax_contributions' => $tax_contributions,
            //     'loan_deductions'=> $loan_deductions,
            //     'tardiness_amount' => $tardiness_amount,
                // 'total_deductions' => $total_deductions,

                // 'taxable' => $taxable,
                // 'non_taxable' => $non_taxable,

            //     'loan_change' => $loan_change,
                
                // 'additional_earnings' => $additional_earnings,
                // 'earnings_collection' => $earnings_collection,
                // 'deductions_collectiwon' => $deductions_collection,
                // 'holidays_collection' => $holidays_collection,
            // ]; 
            // kulang 3
            $collection[$user_id] = $new_collection;
        }
        return $collection;
    }

    public function getSSSContributionAmount($salary)
    {
        $sss_ee = 0;
        $sss_er = 0;
        $sss_ec = 0;
        $sss_rate = SssContributionRate::latest('year')->first();
        if($sss_rate)
        {
            $msc_min = $sss_rate->msc_min;
            $msc_max = $sss_rate->msc_max;
            $ee_share_rate = $sss_rate->ee_share;
            $er_share_rate = $sss_rate->er_share;

            if($salary <= $msc_min)
            {
                $sss_model = SssContributionModel::where('sss_contribution_rate_id', $sss_rate->id)->where('compensation_minimum', 0)->first();
            } 
            elseif($salary >= $msc_max)
            {
                $sss_model = SssContributionModel::where('sss_contribution_rate_id', $sss_rate->id)->where('compensation_maximum', 0)->first();
            } 
            else 
            {
                $sss_model = SssContributionModel::where('sss_contribution_rate_id', $sss_rate->id)
                ->where('compensation_minimum', '<=', $salary)
                ->where('compensation_maximum', '>=', $salary)
                ->first();
            }

            if($sss_model)
            {
                $msc = $sss_model->monthly_salary_credit;
                $sss_ee = $ee_share_rate / 100 * $msc;
                $sss_er = $er_share_rate / 100 * $msc;
                $sss_ec = $sss_model->ec_contribution;
            }
        }
        $data = [
            'ec' => $sss_ec,
            'ee' => $sss_ee,
            'er' => $sss_er,
        ];
        return $data;
    }

    public function getHDMFContributionAmount($rates, $payroll_period_start, $payroll_period_end)
    {
        $total_earnings = 0;
        $hdmf_er = 0;
        $hdmf_ee = 0;
    
        foreach ($rates as $rate) {
            $rateFrom = Carbon::parse($rate['from']);
            $rateTo = Carbon::parse($rate['to']);
            $rateAmount = $rate['rate'];
        
            // Check if the rate falls within the payroll period
            if ($rateFrom <= $payroll_period_end && $rateTo >= $payroll_period_start) {
                // Calculate the number of days the rate applies
                $daysInRange = $rateFrom->diffInDays($rateTo->copy()->endOfDay()) + 1;

                $rateAmount = str_replace(',', '', $rateAmount);
                $rateAmount = floatval($rateAmount);

                // Add the earnings for the specific rate to the total
                $rateEarnings = $rateAmount * $daysInRange;
                $total_earnings += $rateEarnings;
            }
        }

        // Use the total earnings as the basis for HDMF contribution calculation
        $hdmf_contribution_rate = HdmfContributionRate::latest('year')
            ->where('msc_min', '<=', $total_earnings)
            ->where('msc_max', '>=', $total_earnings)
            ->first();
    
        if (!$hdmf_contribution_rate) {
            $hdmf_contribution_rate = HdmfContributionRate::latest('year')
                ->where('msc_min', '<', $total_earnings)
                ->where('msc_max', 0)
                ->first();
        }
    
        if ($hdmf_contribution_rate) {
            $ee_share_rate = $hdmf_contribution_rate->ee_share;
            $er_share_rate = $hdmf_contribution_rate->er_share;
    
            $hdmf_er = $er_share_rate / 100 * $total_earnings;
            $hdmf_ee = $ee_share_rate / 100 * $total_earnings;
        }
    
        $data = [
            'er' => $hdmf_er,
            'ee' => $hdmf_ee,
        ];
        return $data;
    }

    public function getPHICContributionAmount($rates, $payroll_period_start, $payroll_period_end)
    {
        $total_earnings = 0;
        $phic_er = 0;
        $phic_ee = 0;

        foreach ($rates as $rate) {
            $rateFrom = Carbon::parse($rate['from']);
            $rateTo = Carbon::parse($rate['to']);
            $rateAmount = $rate['rate'];

            // Check if the rate falls within the payroll period
            if ($rateFrom <= $payroll_period_end && $rateTo >= $payroll_period_start) {
                // Calculate the number of days the rate applies
                $daysInRange = $rateFrom->diffInDays($rateTo->copy()->endOfDay()) + 1;

                // Convert $rateAmount to a numeric value
                $rateAmount = str_replace(',', '', $rateAmount);
                $rateAmount = floatval($rateAmount);

                // Add the earnings for the specific rate to the total
                $rateEarnings = $rateAmount * $daysInRange;
                $total_earnings += $rateEarnings;
            }
        }

        // Use the total earnings as the basis for PHIC contribution calculation
        $phic_contribution_rate = PhicContributionRate::where('year', Carbon::now()->year)
            ->where('mbs_min', '<=', $total_earnings)
            ->where('mbs_max', '>=', $total_earnings)
            ->first();

        if (!$phic_contribution_rate) {
            $phic_contribution_rate = PhicContributionRate::where('year', Carbon::now()->year)
                ->where('mbs_min', '<', $total_earnings)
                ->where('mbs_max', 0)
                ->first();
        }

        if ($phic_contribution_rate) {
            $share_rate = $phic_contribution_rate->premium_rate / 100;

            $monthly_premium = $share_rate * $total_earnings;
            $phic_er = $monthly_premium / 2;
            $phic_ee = $monthly_premium / 2;
        }

        $data = [
            'er' => $phic_er,
            'ee' => $phic_ee,
        ];
        return $data;
    }

    public function getTotalPaidLeaveHours($user_id, $between_dates)
    {
        $period_start = $between_dates['period_start'];
        $period_end = $between_dates['period_end'];

        $period_range = $this->helper->getRangeBetweenDatesStr($period_start, $period_end);

        $duration_hours = 0;

        // only 1 day
        $leave = Leave::where('user_id', $user_id)
        ->where('status', 2)
        ->where('is_paid', true)
        ->whereIn('type_id', [1,2])
        ->whereNull('end_date')
        ->whereBetween('start_date', [$period_start, $period_end])
        ->get();

        if($leave->count() !=0)
        {
            foreach($leave as $val)
            {
                $duration_hours += $val->hours_duration;
            }
        }

        // leave falls some day in payroll period dates (start date)
        
        $leave_1 = Leave::where('user_id', $user_id)
        ->where('status', 2)
        ->where('is_paid', true)
        ->where('type_id', 3)
        ->where('start_date', '>=', $period_start)
        ->where('end_date', '<=', $period_end)
        ->get();

        $leave_2 = Leave::where('user_id', $user_id)
        ->where('status', 2)
        ->where('is_paid', true)
        ->where('type_id', 3)
        ->where('start_date', '<=', $period_start)
        ->where('end_date', '>=', $period_start)
        ->get();

        $leave = $leave_1->merge($leave_2);

        $leave_3 = Leave::where('user_id', $user_id)
        ->where('status', 2)
        ->where('is_paid', true)
        ->where('type_id', 3)
        ->where('start_date', '<=', $period_end)
        ->where('end_date', '>=', $period_end)
        ->get();

        $leave = $leave->merge($leave_3);

        // count date intersect
        $date_intersect_count = 0;
        $range_valid = [];
        foreach($leave as $val)
        {
            $leave_start_date = $val->start_date;
            $leave_end_date = $val->end_date;

            $range = $this->helper->getRangeBetweenDatesStr($leave_start_date, $leave_end_date);
            $range_valid = array_unique(array_merge($range,$range_valid), SORT_REGULAR);
            $date_intersect_count +=  count(array_intersect($range, $period_range ));
        }

        foreach($range_valid as $date)
        {
            if (($key_in_period_range = array_search($date, $period_range)) === false) {
                $key = array_search($date, $range_valid);
                unset($range_valid[$key]);
            }
        }
        
        // remove rest days
        foreach($range_valid as $date)
        {
            $is_date_working_day = $this->helper->isDateWorkingDay(Carbon::parse($date));
            if(!$is_date_working_day)
            {
                $key = array_search($date, $range_valid);
                unset($range_valid[$key]);
            }
        }
        

        $days_leave = count($range_valid);
        $hours_leave = $days_leave * 8;

        $duration_hours += $hours_leave;
        return $duration_hours;
    }

}