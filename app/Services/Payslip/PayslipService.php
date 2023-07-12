<?php

namespace App\Services\Payslip;

use App\Repositories\Payslip\PayslipRepositoryInterface;
use App\Services\Payslip\PayslipServiceInterface;

use App\Models\User;
use App\Models\Payslip;
use App\Models\PayslipDeduction;
use App\Models\PayrollPeriod;
use App\Models\TaxContribution;
use App\Models\Loan;
use App\Models\LoanInstallment;
use Carbon\Carbon;

class PayslipService implements PayslipServiceInterface
{
    private PayslipRepositoryInterface $modelRepository;

    public function __construct(
        PayslipRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function generate($data)
    {
        foreach($data as $payslip)
        {
            $this->generatePayslip($payslip);
        }
    }

    public function generatePayslip($data)
    {
        $raw_data = $data;
        $payroll_period = PayrollPeriod::find($raw_data['payroll_period_id']);
        $user = User::find($raw_data['user_id']);

        $date = Carbon::now();
        $rates_range = $raw_data['rates_range'];

        $regular = $raw_data['regular'];
        $overtime = $raw_data['overtime'];
        $restday = $raw_data['restday'];
        $restday_ot = $raw_data['restday_ot'];
        $night_differential = $raw_data['night_differential'];
        $late = $raw_data['late'];
        $undertime = $raw_data['undertime'];


        if($payroll_period && $user)
        {
            
            
                // DEDUCTIONS
                    $deductions_collection = $raw_data['deductions_collection'];
                    
                    $hdmf_loan = isset($deductions_collection['hdmf_loan']) ?? null;
                    $sss_loan = isset($deductions_collection['sss_loan']) ?? null;
                    $withholding_tax = 0;
                    $loan = isset($deductions_collection['loan']) ?? null;
                // 


                // LOAN
                    if(isset($deductions_collection['loan'])) { 
                        $loan_amount = (int)$raw_data['deductions_collection']['loan'];
                    } else {
                        $loan_amount = 0;
                    }
                    $loan_change = $loan_amount;
                    if($loan_amount != 0)
                    {
                        $loans = Loan::where('user_id', $user->id)
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
                                $loan_installment = new LoanInstallment;
                                $loan_installment->loan_id = $loan->id;
                                $loan_installment->user_id = $user->id;
                                $loan_installment->pay_date = $date->format('Y-m-d');
                                $loan_installment->amount = $amount_to_pay;
                                $loan_installment->save();
                                
                                $loan_change -= $amount_to_pay;
                                // update loans table
                                $loan->balance = $loan->balance - $amount_to_pay;
                                
                                $balance = 0;
                                $balance += ($loan->pay_next - $amount_to_pay);

                                if($loan->balance >= $loan->installment_amount)
                                {
                                    $balance += $loan->installment_amount;
                                }
                                $loan->pay_next = $balance;
                                $loan->save();
                                
                                
                            }

                        }

                    }
                // 

                // TAX CONTRIBUTIONS

                    $tax_sss = 0;
                    $tax_hdmf = 0;
                    $tax_phic = 0;

                    $cutoff_order = $raw_data['cutoff_order'];

                    if($user->is_tax_exempted == false)
                    {

                        // SSS
                            $sss_tax_contributions = $raw_data['deductions_collection']['tax_contribution']['sss_contribution'];

                            $sss_new_contribution = TaxContribution::firstOrNew(['user_id' => $user->id, 'payroll_period_id' => $payroll_period->id, 'tax_type' => 1]);
                            $sss_new_contribution->cutoff_order = $cutoff_order;
                            $sss_new_contribution->tax_type = 1;
                            $sss_new_contribution->employee_share = $sss_tax_contributions['ee'];
                            $sss_new_contribution->employer_share = $sss_tax_contributions['er'];
                            $sss_new_contribution->save();
                            $tax_sss = $sss_tax_contributions['ee'];
                        // 

                        // HDMF
                            $hdmf_tax_contributions = $raw_data['deductions_collection']['tax_contribution']['hdmf_contribution'];

                            $hdmf_new_contribution = TaxContribution::firstOrNew(['user_id' => $user->id, 'payroll_period_id' => $payroll_period->id, 'tax_type' => 2]);
                            $hdmf_new_contribution->cutoff_order = $cutoff_order;
                            $hdmf_new_contribution->tax_type = 2;
                            $hdmf_new_contribution->employee_share = $hdmf_tax_contributions['total_ee'];
                            $hdmf_new_contribution->employer_share = $hdmf_tax_contributions['total_er'];
                            $hdmf_new_contribution->save();

                            $tax_hdmf = $hdmf_tax_contributions['total_ee'];
                        // 

                        // PHIC
                            $phic_tax_contributions = $raw_data['deductions_collection']['tax_contribution']['phic_contribution'];

                            $phic_new_contribution = TaxContribution::firstOrNew(['user_id' => $user->id, 'payroll_period_id' => $payroll_period->id, 'tax_type' => 3]);
                            $phic_new_contribution->cutoff_order = $cutoff_order;
                            $phic_new_contribution->tax_type = 3;
                            $phic_new_contribution->employee_share = $phic_tax_contributions['total_ee'];
                            $phic_new_contribution->employer_share = $phic_tax_contributions['total_er'];
                            $phic_new_contribution->save();

                            $tax_phic = $phic_tax_contributions['total_ee'];
                        // 

                    }
                // 

                // LABELS
                    // daily_rate
                    // designation
                    // number_dependent

                    // hours
                        // regular
                        // overtime
                        // restday
                        // restday_ot
                        // night_diff
                        // late
                        // undertime

                    // earnings
                        // adjustment
                        // overtime_pay
                        // restday_pay
                        // restday_ot_pay
                        // night_diff_pay
                        // holiday
                            // legal
                            // legal_ot
                            // special
                            // special_ot
                            // double
                            // double_ot
                        // additional earnings
                            // bonus
                            // etc

                    // deductions
                        // absences
                        // late
                        // undertime
                        // cash advance
                        // sss_loan
                        // hdmf_loan
                        
                        // tax_contributions
                            // sss
                            // hdmf
                            // phic


                // 

                // LABEL COLLECTION
                    // dd($raw_data);
                    $designation = "";
                    if($user->latestDesignation() != null)
                    {
                        $designation = $user->latestDesignation()->designation_name;
                    }
                    
                    $label_additional_earnings = isset($raw_data['earning_collections']['additional_earnings']) ?? null;
                    // 
                        $adjustment = 0;
                        if(isset($label_additional_earnings['Adjustments'])) 
                        {
                            $adjustment = $label_additional_earnings['Adjustments'];
                        }
                    // 
                    // holidays
                        $holidays_collection = $raw_data['holidays_collection'];
                    // 

                    // deductions collction
                        $sss_to_pay = 0;
                        $hdmf_to_pay = 0;
                        $phic_to_pay = 0;
                        $label_deductions_collection = $raw_data['deductions_collection'];
                        if(array_key_exists('tax_contribution', $label_deductions_collection))
                        {
                            $label_tax_contributions = $label_deductions_collection['tax_contribution'];
                            $sss_to_pay = $label_tax_contributions['sss_contribution']['ee'];
                            $hdmf_to_pay = $label_tax_contributions['hdmf_contribution']['total_ee'];
                            $phic_to_pay = $label_tax_contributions['phic_contribution']['total_ee'];
                        }
                        
                    // 
                    // dd($raw_data);
                    $label_collection = [
                        'rates_range' => $rates_range,
                        'designation' => $designation,
                        'number_dependent' => $user->number_dependent,
                        'hours' => [
                            'regular' => $regular,
                            'overtime' => $overtime,
                            'restday' => $restday,
                            'restday_ot' => $restday_ot,
                            'night_differential' => $night_differential,
                            'late' => $late,
                            'undertime' => $undertime,
                        ],
                        'earnings' => [
                            'overtime_pay' => $raw_data['earning_collections']['overtime'],
                            'restday_pay' => $raw_data['earning_collections']['restday'],
                            'restday_ot_pay' => $raw_data['earning_collections']['restday_ot'],
                            'night_diff_pay' => $raw_data['earning_collections']['night_differential'],
                            'holiday' => [
                                'legal' => $holidays_collection['legal'],
                                'legal_ot' => $holidays_collection['legal_ot'],
                                'special' => $holidays_collection['special'],
                                'special_ot' => $holidays_collection['special_ot'],
                                'double' => $holidays_collection['double'],
                                'double_ot' => $holidays_collection['double_ot'],
                            ],
                            'others' => $label_additional_earnings,
                        ],
                        'deductions' => [
                            'late' => isset($label_deductions_collection['late']) ?? null,
                            'undertime' => isset($label_deductions_collection['undertime']) ?? null,
                            'absences' => isset($label_deductions_collection['absences']) ?? null,
                            'cash_advance' => $loan_amount,
                            'sss_loan' => isset($label_deductions_collection['sss_loan']) ?? null,
                            'hdmf_loan' => isset($label_deductions_collection['hdmf_loan']) ?? null,
                            'tax_contribution' => [
                                'sss' => $sss_to_pay,
                                'phic' => $hdmf_to_pay,
                                'hdmf' => $phic_to_pay,
                            ]
                        ]
                    ];
                // 


                // PAYSLIP
                    $new_payslip = Payslip::firstOrNew(['user_id'=>$user->id, 'payroll_period_id'=>$payroll_period->id]);
                    $new_payslip->user_id = $user->id;
                    $new_payslip->payroll_period_id = $payroll_period->id;
                    $new_payslip->cutoff_order = $cutoff_order;
                    $new_payslip->is_paid = false;
                    
                    $new_payslip->basic_pay = $raw_data['basic_pay'];
                    $new_payslip->gross_pay = $raw_data['gross_pay'];
                    $new_payslip->net_pay = $raw_data['net_pay'];
                    
                    $new_payslip->tardiness = isset($raw_data['preview_data']['deductions']['tardiness']['amount']) ?? null;
                    $new_payslip->deductions = $raw_data['total_deductions'];

                    $new_payslip->taxable = $raw_data['taxable'];
                    $new_payslip->non_taxable = $raw_data['non_taxable'];
                    
                    $new_payslip->labels = json_encode($label_collection);
                    $new_payslip->save();


                    // new payslip deductions

                    $new_payslip_deductions = PayslipDeduction::firstOrNew(['payslip_id'=>$new_payslip->id]);
                    $new_payslip_deductions->tax_sss = $tax_sss;
                    $new_payslip_deductions->tax_hdmf = $tax_hdmf;
                    $new_payslip_deductions->tax_phic = $tax_phic;
                    $new_payslip_deductions->hdmf_loan = $hdmf_loan; 
                    $new_payslip_deductions->sss_loan = $sss_loan; 
                    $new_payslip_deductions->withholding_tax = $withholding_tax; 
                    $new_payslip_deductions->loan = $loan_amount; 
                    $new_payslip_deductions->save(); 


                // 
            
        }

        return 'success';
    }

    public function payslipViewDataVariable($payslip)
    {
        

        $payout_date = Carbon::parse($payslip->payroll_period->payout_date)->format('F d, Y');
        $pay_period = Carbon::parse($payslip->payroll_period->period_start)->format('M d') . " - " . Carbon::parse($payslip->payroll_period->period_end)->format('M d');
        
        $labels = json_decode($payslip->labels, true);

        $user = User::withTrashed()->find($payslip->user_id);
        $daily_rate = $labels['daily_rate'];
        $designation = $labels['designation'];
        $full_name = $user->formal_name();



        $basic_pay = $payslip->basic_pay;
        $basic_pay_hours = $labels['hours']['regular'];

        $overtime_pay =  $labels['earnings']['overtime_pay'];
        $overtime_hours =  $labels['hours']['overtime'];

        $restday_pay =  $labels['earnings']['restday_pay'];
        $restday_hours =  $labels['hours']['restday'];

        $restday_ot_pay =  $labels['earnings']['restday_ot_pay'];
        $restday_ot_hours =  $labels['hours']['restday_ot'];

        $night_differential_pay =  $labels['earnings']['night_diff_pay'];
        $night_differential_hours =  $labels['hours']['night_differential'];

        $label_holiday = $labels['earnings']['holiday'];
        $holiday_pay = 0;
        foreach($label_holiday as $holiday)
        {
            $holiday_pay += $holiday;
        }

        $others_pay = 0;
        $label_others = $labels['earnings']['others'];
        foreach($label_others as $other)
        {
            $others_pay += $other;
        }

        $gross_pay = $payslip->gross_pay;
        $net_pay = $payslip->net_pay;

        // DEDUCTIONS
        $label_deductions = $labels['deductions'];

        $late_hours = $labels['hours']['late'];
        $undertime_hours = $labels['hours']['undertime'];

        $late = $label_deductions['late'];
        $undertime = $label_deductions['undertime'];
        $absences = $label_deductions['absences'];
        $cash_advance = $label_deductions['cash_advance'];
        $sss_loan = $label_deductions['sss_loan'];
        $hdmf_loan = $label_deductions['hdmf_loan'];
        $sss = $label_deductions['tax_contribution']['sss'];
        $phic = $label_deductions['tax_contribution']['phic'];
        $hdmf = $label_deductions['tax_contribution']['hdmf'];

        $deductions = $payslip->deductions;


        $data = [
            'payout_date' => $payout_date,
            'pay_period' => $pay_period,
            'daily_rate' => $daily_rate,
            'full_name' => $full_name,
            'code' => $user->code,
            'designation' => $designation,
            'basic_pay' => $basic_pay,
            'basic_pay_hours' => $basic_pay_hours,
            'overtime_pay' => $overtime_pay,
            'overtime_hours' => $overtime_hours,
            'restday_pay' => $restday_pay,
            'restday_hours' => $restday_hours,
            'restday_ot_pay' => $restday_ot_pay,
            'restday_ot_hours' => $restday_ot_hours,
            'night_differential_pay' => $night_differential_pay,
            'night_differential_hours' => $night_differential_hours,
            'gross_pay' => $gross_pay,
            'late_hours' => $late_hours,
            'undertime_hours' => $undertime_hours,
            'late' => $late,
            'undertime' => $undertime,
            'absences' => $absences,
            'cash_advance' => $cash_advance,
            'sss_loan' => $sss_loan,
            'hdmf_loan' => $hdmf_loan,
            'sss' => $sss,
            'phic' => $phic,
            'hdmf' => $hdmf,
            'deductions' => $deductions,
            'net_pay' => $net_pay,
        ];

        return $data;
    }
}