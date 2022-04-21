<?php

namespace App\Classes\Payroll;
use App\Models\User;
use App\Models\PayrollPeriod;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\Loan;
use App\Models\LoanInstallment;
use App\Models\Earning;
use App\Models\Payslip;

use App\Models\SssContributionRate;
use App\Models\SssContributionModel;
use App\Models\HdmfContributionRate;
use App\Models\PhicContributionRate;

use App\Models\TaxContribution;

use Carbon\Carbon;
use Helper;

class PayrollClass {
    
    
    public function payroll($data)
    {
        $raw_collection = (json_decode($data->data,true));

        $period_start = $data->period_start;
        $period_end = $data->period_end;

        $between_dates = [
            'period_start' => $period_start,
            'period_end' => $period_end,
        ];

        $date_range = Helper::getRangeBetweenDatesStr($period_start, $period_end);

        $payroll_period = PayrollPeriod::where('period_start', $period_start)
        ->where('period_end', $period_end)
        ->first();

        $collection = [];

        foreach($raw_collection as $raw_collection_user)
        {
            $user_id = $raw_collection_user['id'];
            $daily_rate = $raw_collection_user['daily_rate'];
            $hourly_rate = $daily_rate / 8;

            $raw_hours = $raw_collection_user['total_hours'];
            $raw_additional_earnings = $raw_collection_user['additional_earnings'];
            $raw_deductions = $raw_collection_user['deductions'];

            $user = User::find($user_id);

            // BASIC PAY
                // $total_days_present_or_late = Self::getTotalDaysPresentOrLate($user_id, $between_dates);
                // $present_pay = $total_days_present_or_late * $daily_rate;

                $paid_leave_hours = Self::getTotalPaidLeaveHours($user_id, $between_dates);
                $leave_pay = $paid_leave_hours * $hourly_rate;

                // $basic_pay = $present_pay + $leave_pay;
                $monthly_basic_pay = $daily_rate * 261 / 12;
                
                if($payroll_period->frequency_id == 1)
                {
                    // semi-monthly
                    $basic_pay = $monthly_basic_pay / 2;
                }
                if($payroll_period->frequency_id == 2)
                {
                    $basic_pay = $daily_rate * 5;
                }
            // 

            // EARNINGS 
                $holiday_pay = 0;
                $regular_hours = 0;
                $overtime_hours = 0;
                $restday_hours = 0;
                $restday_ot_hours = 0;
                $night_diff_hours = 0;

                $regular = 0;
                $overtime = 0;
                $restday = 0;
                $restday_ot = 0;
                $night_diff = 0;

                foreach($raw_hours as $raw_hour)
                {
                    switch($raw_hour['name'])
                    {
                        case 'Regular':
                            $regular_hours = $raw_hour['amount'];
                            break;
                        case 'Overtime':
                            $overtime_hours = $raw_hour['amount'];
                            break;
                        case 'Restday':
                            $restday_hours = $raw_hour['amount'];
                            break;
                        case 'RestdayOT':
                            $restday_ot_hours = $raw_hour['amount'];
                            break;
                        case 'Night Diff':
                            $night_diff_hours = $raw_hour['amount'];
                    }
                }

                $regular = $regular_hours * $hourly_rate;
                $overtime = $overtime_hours * $hourly_rate * 1.25;

                $restday = $restday_hours * $hourly_rate * 1.30;
                $restday_ot = $restday_ot_hours * $hourly_rate * 1.69;

                $night_diff = $night_diff_hours * $hourly_rate * .10;

                $earnings = $regular + $overtime + $restday + $restday_ot + $night_diff;
                $earnings_collection = [
                    'regular' => $regular,
                    'overtime' => $overtime,
                    'restday' => $restday,
                    'restday_ot' => $restday_ot,
                    'night_diff' => $night_diff,
                ];
                
            // 

            // HOLIDAY
                $holidays_collection = [];

                
                $holiday_regular_pay = 0;
                $holiday_overtime_pay = 0;
                $holiday_restday_pay = 0;
                $holiday_restday_overtime_pay = 0;

                $legal_holiday_pay = 0;
                $legal_ot_holiday_pay = 0;
                $special_holiday_pay = 0;
                $special_ot_holiday_pay = 0;
                $double_holiday_pay = 0;
                $double_ot_holiday_pay = 0;

                if($user->is_paid_holidays == true)
                {
                    


                    foreach($date_range as $date)
                    {
                        
                        // ordinary
                        $attendances_holiday_ordinary = Attendance::where('user_id', $user_id)
                        ->whereIn('status', [1,2])
                        ->where('date', $date)
                        ->get();

                        // restday
                        $attendances_holiday_restday = Attendance::where('user_id', $user_id)
                        ->where('status', 3)
                        ->where('date', $date)
                        ->get();

                        $rh = $attendances_holiday_ordinary->sum('regular');
                        $ot = $attendances_holiday_ordinary->sum('overtime');
                        $sot = $attendances_holiday_restday->sum('regular');
                        $sot_ot = $attendances_holiday_restday->sum('overtime');

                        
                        // get holidays
                        $holidays = Holiday::where('date', $date)->get();
                        
                        if($holidays->count() == 1)
                        {
                            // legal 
                            if($holidays[0]->is_legal == true)
                            {
                                $holiday_regular_pay += ($rh * $hourly_rate);
                                $holiday_overtime_pay += ($ot * $hourly_rate * 1.60);

                                $holiday_restday_pay += ($sot * $hourly_rate * 1.3);
                                $holiday_restday_overtime_pay += ($sot_ot * $hourly_rate * 1.69);

                                $legal_holiday_pay += ($rh * $hourly_rate);
                                $legal_ot_holiday_pay += ($ot * $hourly_rate * 1.60);
                                $legal_holiday_pay += ($sot * $hourly_rate * 1.3);
                                $legal_ot_holiday_pay += ($sot_ot * $hourly_rate * 1.69);
                            }
                            else 
                            {
                                $holiday_regular_pay += ($rh * $hourly_rate * .3);
                                $holiday_overtime_pay += ($ot * $hourly_rate * .69);
                                
                                $holiday_restday_pay += ($sot * $hourly_rate * .2);
                                $holiday_restday_overtime_pay += ($sot_ot * $hourly_rate * .26);

                                $special_holiday_pay += ($rh * $hourly_rate * .3);
                                $special_ot_holiday_pay += ($ot * $hourly_rate * .69);
                                $special_holiday_pay += ($sot * $hourly_rate * .2);
                                $special_ot_holiday_pay += ($sot_ot * $hourly_rate * .26);
                            }
                        }
                        elseif($holidays->count() > 1)
                        {
                            // double
                            $holiday_regular_pay += ($rh * $hourly_rate * 2);
                            $holiday_overtime_pay += ($ot * $hourly_rate * 2.90);
                            $holiday_restday_pay += ($sot * $hourly_rate * 2.6);
                            $holiday_restday_overtime_pay += ($sot_ot * $hourly_rate * 3.38);

                            $double_holiday_pay += ($rh * $hourly_rate * 2);
                            $double_ot_holiday_pay += ($ot * $hourly_rate * 2.90);
                            $double_holiday_pay += ($sot * $hourly_rate * 2.6);
                            $double_ot_holiday_pay += ($sot_ot * $hourly_rate * 3.38);
                        }

                    }

                    

                    $holiday_pay = $holiday_regular_pay + $holiday_overtime_pay + $holiday_restday_pay + $holiday_restday_overtime_pay;
                    
                }
                
                $holidays_collection = [
                    'regular'=> $holiday_regular_pay,
                    'overtime'=> $holiday_overtime_pay,
                    'restday'=> $holiday_restday_pay,
                    'restday_overtime'=> $holiday_restday_overtime_pay,
                    'legal'=>$legal_holiday_pay,
                    'legal_ot'=>$legal_ot_holiday_pay,
                    'special'=>$special_holiday_pay,
                    'special_ot'=>$special_ot_holiday_pay,
                    'double' =>$double_holiday_pay,
                    'double_ot' =>$double_ot_holiday_pay,
                ];
            // 

            // ADDITIONAL EARNINGS, TAXABLE, NONTAXABLE
                $taxable = 0;
                $non_taxable = 0;
                $additional_earnings = 0;
                foreach($raw_additional_earnings as $raw_additional_earning)
                {
                    $earning_type = Earning::where('name', $raw_additional_earning['name'])->first();
                    if($earning_type)
                    {
                        $amount = $raw_additional_earning['amount'];
                        $additional_earnings += $amount;
                        $earnings_collection['additional_earnings'][$earning_type->name] = $amount;
                        if($earning_type->is_taxable == true)
                        {
                            $taxable += $amount;
                        }
                        else
                        {
                            $non_taxable += $amount;
                        }
                    }
                }
            // 

            // GROSS PAY AND TOTAL TAXABLE
                $taxable += $earnings + $holiday_pay + $leave_pay + $taxable;
                $gross_pay = $taxable + $non_taxable;
            // 

            // DEDUCTIONS
                $total_deductions = 0;
                $loan_deductions = 0;
                $deductions_collection = [];

                $late_hours = 0;
                $undertime_hours = 0;
                $loan_amount = 0;
                $sss_loan = 0;
                $hdmf_loan = 0;
                foreach($raw_deductions as $raw_deduction)
                {
                    $amount = (int)$raw_deduction['amount'];
                    switch($raw_deduction['name'])
                    {
                        case 'Late(hr)':
                            $late_hours = $amount;
                            break;
                        case 'Undertime(hr)':
                            $undertime_hours = $amount;
                            break;
                        case 'Loan':
                            $loan_amount = $amount;
                            break;
                        case 'SSS Loan':
                            $sss_loan = $amount;
                            break;
                        case 'HDMF Loan':
                            $hdmf_loan = $amount;
                    }
                }

                // TARDINESS
                    $data_for_absences_function = 
                    [
                        'daily_rate' => $daily_rate,
                        'user_id' => $user_id,
                    ];

                    $late_amount = $late_hours * $hourly_rate;
                    $undertime_amount = $undertime_hours * $hourly_rate;

                    $absences_amount = Self::getTotalAbsencesTardinesss($between_dates, $data_for_absences_function);
                    $tardiness_amount = $late_amount + $undertime_amount + $absences_amount;
                    $deductions_collection['late'] = $late_amount;
                    $deductions_collection['undertime'] = $undertime_amount;
                    $deductions_collection['absences'] = $absences_amount;
                // 

                // SSS AND HDMF LOAN, and cash advance
                    $deductions_collection['loan'] = $loan_amount;
                    $deductions_collection['sss_loan'] = $sss_loan;
                    $deductions_collection['hdmf_loan'] = $hdmf_loan;
                    
                    $loan_change = (int)$loan_amount;
                    if($loan_amount != 0)
                    {
                        $loans = Loan::where('user_id', $user_id)
                        ->where('status', 2) // approved
                        ->where('balance', '!=', 0)
                        ->get();

                        foreach($loans as $loan)
                        {
                            
                            if($loan_change != 0)
                            {
                                $amount_to_pay = $loan_change;
                                
                                if($loan_change >= $loan->pay_next)
                                {
                                    $amount_to_pay = $loan->pay_next;
                                }
                                // $loan_installment = new LoanInstallment;
                                // $loan_installment->loan_id = $loan->id;
                                // $loan_installment->user_id = $user_id;
                                // $loan_installment->pay_date = $date;
                                // $loan_installment->amount = $amount_to_pay;
                                // $loan_installment->save();
                                
                                $loan_change -= $amount_to_pay;
                                // update loans table
                                $loan->balance = $loan->balance - $amount_to_pay;
                                
                                $balance = 0;
                                $balance += ($loan->pay_next - $amount_to_pay);

                                if($loan->balance >= $loan->installment_amount)
                                {
                                    $balance += $loan->installment_amount;
                                }
                                // $loan->pay_next = $balance;
                                // $loan->save();
                                
                                
                            }

                        }

                    }

                    $loan_deductions = $loan_amount + $sss_loan + $hdmf_loan;
            
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
                            $salary = $taxable;
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

                                $previous_payslips = Payslip::where('user_id', $user->id)
                                ->whereIn('payroll_period_id', [$payroll_period_ids])
                                ->get();

                                $salary = $taxable + $payslips->sum('taxable');
                            }
                        }

                        $tax_divide = 2;
                        if($user->frequency_id == 2)
                        {
                            $tax_divide = 4;
                        }

                        // SSS CONTRIBUTION (TYPE 1)
                            $sss_monthly_tax_contribution = Self::getSSSContributionAmount($salary);

                            $sss_er_to_pay = $sss_monthly_tax_contribution['er'];
                            $sss_ee_to_pay = $sss_monthly_tax_contribution['ee'];
                            $sss_ec_to_pay = $sss_monthly_tax_contribution['ec'] / $tax_divide;

                            if($cutoff_order != 1)
                            {
                                $paid_tax_sss = TaxContribution::where('user_id', $user_id)
                                ->where('tax_type', 1)
                                ->whereIn('payroll_period_id', [$payroll_period_ids])
                                ->get();
                                $sss_er_paid = $paid_tax_sss->sum('employer_share');
                                $sss_ee_paid = $paid_tax_sss->sum('employee_share');

                                $sss_er_to_pay = $sss_monthly_tax_contribution['er'] - $sss_er_paid;
                                $sss_ee_to_pay = $sss_monthly_tax_contribution['ee'] - $sss_ee_paid;
                            } 
                            $deductions_collection['tax_contribution']['sss_contribution'] = [
                                'er' => $sss_er_to_pay,
                                'ee' => $sss_ee_to_pay,
                                'ec' => $sss_ec_to_pay,
                            ];

                            $tax_contributions += $sss_ee_to_pay;

                        // 

                        // HDMF CONTRIBUTION (TYPE 2)
                            $hdmf_monthly_tax_contribution = Self::getHDMFContributionAmount($monthly_basic_pay);
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
                                ->whereIn('payroll_period_id', [$payroll_period_ids])
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

                            $deductions_collection['tax_contribution']['hdmf_contribution'] = [
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
                            $phic_monthly_tax_contribution = Self::getPHICContributionAmount($monthly_basic_pay);
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
                                ->whereIn('payroll_period_id', [$payroll_period_ids])
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

                            $deductions_collection['tax_contribution']['phic_contribution'] = [
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
                    }
                    
                // 


                // total
                $total_deductions = $tardiness_amount + $loan_deductions + $tax_contributions;
            // 

            // NET PAY
                $gross_pay = $basic_pay + $holiday_pay + $overtime + $restday + $restday_ot + $night_diff + $additional_earnings;
                $net_pay = $gross_pay - $total_deductions;
                if($net_pay < 0)
                {
                    $total_deductions -= $tax_contributions;
                    $tax_contributions = 0;
                    $deductions_collection['tax_contribution']['sss_contribution']['ee'] = 0;
                    $deductions_collection['tax_contribution']['hdmf_contribution']['total_ee'] = 0;
                    $deductions_collection['tax_contribution']['phic_contribution']['total_ee'] = 0;

                    $net_pay = $gross_pay - $total_deductions;
                }
                // $net_pay = $basic_pay + $holiday_pay + $overtime + $restday + $restday_ot + $night_diff + $additional_earnings - $total_deductions;
            // 

            // COLLECTION
            $collection[$user_id] = 
            [
                'user_id' => $user_id,
                'cutoff_order' => $cutoff_order,
                'payroll_period_id' => $payroll_period->id,
                'full_name' => $user->formal_name(),
                'monthly_basic_pay' => $monthly_basic_pay,
                'daily_rate' => $daily_rate,

                'regular' => $regular_hours,
                'overtime' => $overtime_hours,
                'restday' => $restday_hours,
                'restday_ot' => $restday_ot_hours,
                'night_differential' => $night_diff_hours,
                'late' => $late_hours,
                'undertime' => $undertime_hours,
                
                'basic_pay' => $basic_pay,
                'gross_pay' => $gross_pay,
                'net_pay' => $net_pay,

                'is_tax_exempted' => $user->is_tax_exempted,
                'tax_contributions' => $tax_contributions,
                'loan_deductions'=> $loan_deductions,
                'tardiness_amount' => $tardiness_amount,
                'total_deductions' => $total_deductions,

                'taxable' => $taxable,
                'non_taxable' => $non_taxable,

                'loan_change' => $loan_change,
                
                'additional_earnings' => $additional_earnings,
                'earnings_collection' => $earnings_collection,
                'deductions_collection' => $deductions_collection,
                'holidays_collection' => $holidays_collection,
            ];

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

    public function getHDMFContributionAmount($monthly_basic_salary)
    {
        $hdmf_er = 0;
        $hdmf_ee = 0;
        $hdmf_contribution_rate = HdmfContributionRate::latest('year')
        ->where('msc_min', '<=', $monthly_basic_salary)
        ->where('msc_max', '>=', $monthly_basic_salary)
        ->first();

        if(!$hdmf_contribution_rate)
        {
            $hdmf_contribution_rate = HdmfContributionRate::latest('year')
            ->where('msc_min', '<', $monthly_basic_salary)
            ->where('msc_max', 0)
            ->first();
        }

        if($hdmf_contribution_rate)
        {
            $ee_share_rate = $hdmf_contribution_rate->ee_share;
            $er_share_rate = $hdmf_contribution_rate->er_share;

            $hdmf_er = $er_share_rate / 100 * $monthly_basic_salary;
            $hdmf_ee = $ee_share_rate / 100 * $monthly_basic_salary;
        }

        $data = [
            'er' => $hdmf_er,
            'ee' => $hdmf_ee,
        ];
        return $data;
    }

    public function getPHICContributionAmount($monthly_basic_salary)
    {
        $phic_er = 0;
        $phic_ee = 0;
        $phic_contribution_rate = PhicContributionRate::where('year', Carbon::now('Y'))
        ->where('mbs_min', '<=', $monthly_basic_salary)
        ->where('mbs_max', '>=', $monthly_basic_salary)
        ->first();

        
        if(!$phic_contribution_rate)
        {
            $phic_contribution_rate = PhicContributionRate::where('year', Carbon::now('Y'))
            ->where('mbs_min', '<', $monthly_basic_salary)
            ->where('mbs_max', 0)
            ->first();
        }

        if($phic_contribution_rate)
        {
            $share_rate = $phic_contribution_rate->premium_rate / 100;

            $monthly_premium = $share_rate * $monthly_basic_salary;
            $phic_er = $monthly_premium / 2;
            $phic_ee = $monthly_premium / 2;
        }

        $data = [
            'er' => $phic_er,
            'ee' => $phic_ee,
        ];
        return $data;
    }

    public function getTotalDaysPresentOrLate($user_id, $between_dates)
    {
        $period_start = $between_dates['period_start'];
        $period_end = $between_dates['period_end'];

        $period_range = Helper::getRangeBetweenDatesStr($period_start, $period_end);

        $days_present = 0;
        foreach($period_range as $date)
        {
            $attendances = Attendance::where('user_id', $user_id)
            ->whereIn('status', [1,2])
            ->where('date', $date)
            ->get();
            if($attendances->count() != 0)
            {
                $days_present ++;
            }
        }

        return $days_present;
    }

    public function getTotalPaidLeaveHours($user_id, $between_dates)
    {
        $period_start = $between_dates['period_start'];
        $period_end = $between_dates['period_end'];

        $period_range = Helper::getRangeBetweenDatesStr($period_start, $period_end);

        $duration_hours = 0;

        // only 1 day
        $leave = Leave::where('user_id', $user_id)
        ->where('approved', true)
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
        ->where('approved', true)
        ->where('is_paid', true)
        ->where('type_id', 3)
        ->where('start_date', '>=', $period_start)
        ->where('end_date', '<=', $period_end)
        ->get();

        $leave_2 = Leave::where('user_id', $user_id)
        ->where('approved', true)
        ->where('is_paid', true)
        ->where('type_id', 3)
        ->where('start_date', '<=', $period_start)
        ->where('end_date', '>=', $period_start)
        ->get();

        $leave = $leave_1->merge($leave_2);

        $leave_3 = Leave::where('user_id', $user_id)
        ->where('approved', true)
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

            $range = Helper::getRangeBetweenDatesStr($leave_start_date, $leave_end_date);
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
            $is_date_working_day = Helper::isDateWorkingDay(Carbon::parse($date));
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

    public function getTotalAbsencesTardinesss($between_dates, $data)
    {
        $period_start = $between_dates['period_start'];
        $period_end = $between_dates['period_end'];

        $daily_rate = $data['daily_rate'];
        $user_id = $data['user_id'];

        $date_range = Helper::getRangeBetweenDatesStr($period_start, $period_end);
        // remove rest days
        foreach($date_range as $date)
        {
            $is_date_working_day = Helper::isDateWorkingDay(Carbon::parse($date));
            if(!$is_date_working_day)
            {
                $key = array_search($date, $date_range);
                unset($date_range[$key]);
            }
        }
        $amount = 0;

        foreach($date_range as $date)
        {
            
            $attendance = Attendance::where('user_id', $user_id)
            ->whereIn('status', [1,2])
            ->where('date', $date)
            ->get();

            if($attendance->count() == 0)
            {
                // absent ka potangina
                // only 1 day
                $leave = Leave::where('user_id', $user_id)
                ->where('approved', true)
                ->where('is_paid', false)
                ->whereIn('type_id', [1,2])
                ->whereNull('end_date')
                ->where('start_date', $date)
                ->first();

                if($leave)
                {
                    if($leave->type_id == 2){
                        $amount += ($daily_rate / 2);
                    } else {
                        $amount += $daily_rate;
                    }
                    
                }

                if(!$leave)
                {
                    $leave = Leave::where('user_id', $user_id)
                    ->where('approved', true)
                    ->where('is_paid', true)
                    ->where('type_id', 3)
                    ->where('start_date', '<=', $period_end)
                    ->where('end_date', '>=', $period_end)
                    ->get();
                }

                if($leave->count() == 0)
                {
                    $amount += $daily_rate;
                }
            }
        }

        return $amount;
    }
}
