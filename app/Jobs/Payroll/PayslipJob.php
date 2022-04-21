<?php

namespace App\Jobs\Payroll;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;
use App\Models\Payslip;
use App\Models\PayslipDeduction;
use App\Models\PayrollPeriod;
use App\Models\TaxContribution;
use App\Models\Loan;
use App\Models\LoanInstallment;

use Carbon\Carbon;

class PayslipJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $raw_data = $this->data;
        $payroll_period = PayrollPeriod::find($raw_data['payroll_period_id']);
        $user = User::find($raw_data['user_id']);

        $date = Carbon::now();
        $daily_rate = $raw_data['daily_rate'];

        $regular = $raw_data['regular'];
        $overtime = $raw_data['overtime'];
        $restday = $raw_data['restday'];
        $restday_ot = $raw_data['restday_ot'];
        $night_differential = $raw_data['night_differential'];
        $late = $raw_data['late'];
        $undertime = $raw_data['undertime'];


        if($payroll_period && $user)
        {
            $payslip = Payslip::where('user_id', $user->id)
            ->where('payroll_period_id')
            ->first();
            
            // payslip exist
            if($payslip)
            {

            }
            else 
            {
                // DEDUCTIONS
                    $deductions_collection = $raw_data['deductions_collection'];
                    
                    $hdmf_loan = $deductions_collection['hdmf_loan'];
                    $sss_loan = $deductions_collection['sss_loan'];
                    $withholding_tax = 0;
                    $loan = $deductions_collection['loan'];
                // 


                // LOAN
                    $loan_amount = $raw_data['deductions_collection']['loan'];
                    $loan_change = $loan_amount;
                    // dd($raw_data['deductions_collection']);
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
                                $loan_installment->pay_date = $date;
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

                            $sss_new_contribution = new TaxContribution;
                            $sss_new_contribution->user_id = $user->id;
                            $sss_new_contribution->cutoff_order = $cutoff_order;
                            $sss_new_contribution->payroll_period_id = $payroll_period->id;
                            $sss_new_contribution->tax_type = 1;
                            $sss_new_contribution->employee_share = $sss_tax_contributions['ee'];
                            $sss_new_contribution->employer_share = $sss_tax_contributions['er'];
                            $sss_new_contribution->save();
                            $tax_sss = $sss_tax_contributions['ee'];
                        // 

                        // HDMF
                            $hdmf_tax_contributions = $raw_data['deductions_collection']['tax_contribution']['hdmf_contribution'];

                            $hdmf_new_contribution = new TaxContribution;
                            $hdmf_new_contribution->user_id = $user->id;
                            $hdmf_new_contribution->cutoff_order = $cutoff_order;
                            $hdmf_new_contribution->payroll_period_id = $payroll_period->id;
                            $hdmf_new_contribution->tax_type = 1;
                            $hdmf_new_contribution->employee_share = $hdmf_tax_contributions['total_ee'];
                            $hdmf_new_contribution->employer_share = $hdmf_tax_contributions['total_er'];
                            $hdmf_new_contribution->save();

                            $tax_hdmf = $hdmf_tax_contributions['total_ee'];
                        // 

                        // PHIC
                            $phic_tax_contributions = $raw_data['deductions_collection']['tax_contribution']['phic_contribution'];

                            $phic_new_contribution = new TaxContribution;
                            $phic_new_contribution->user_id = $user->id;
                            $phic_new_contribution->cutoff_order = $cutoff_order;
                            $phic_new_contribution->payroll_period_id = $payroll_period->id;
                            $phic_new_contribution->tax_type = 1;
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
                    
                    $designation = "";
                    if($user->latestDesignation() != null)
                    {
                        $designation = $user->latestDesignation()->name;
                    }
                    
                    $label_additional_earnings = $raw_data['earnings_collection']['additional_earnings'];
                    // 
                        $adjustment = 0;
                        if(array_key_exists('Adjustments', $label_additional_earnings))
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
                    $label_collection = [
                        'daily_rate' => $daily_rate,
                        'designation' => $designation,
                        'number_dependent' => $user->number_dependent,
                        'Hours' => [
                            'Regular' => $regular,
                            'Overtime' => $overtime,
                            'Restday' => $restday,
                            'Restday OT' => $restday_ot,
                            'Night Differential' => $night_differential,
                            'Late' => $late,
                            'Undertime' => $undertime,
                        ],
                        'Earnings' => [
                            'Adjustment' => $adjustment,
                            'Holiday' => [
                                'Legal' => $holidays_collection['legal'],
                                'Legal OT' => $holidays_collection['legal_ot'],
                                'Special' => $holidays_collection['special'],
                                'Special OT' => $holidays_collection['special_ot'],
                                'Double' => $holidays_collection['double'],
                                'Double OT' => $holidays_collection['double_ot'],
                            ],
                            'Others' => $label_additional_earnings,
                        ],
                        'Deductions' => [
                            'Late' => $label_deductions_collection['late'],
                            'Undertime' => $label_deductions_collection['undertime'],
                            'Absences' => $label_deductions_collection['absences'],
                            'Cash Advance' => $label_deductions_collection['loan'],
                            'SSS Loan' => $label_deductions_collection['sss_loan'],
                            'HDMF Loan' => $label_deductions_collection['hdmf_loan'],
                            'Tax Contribution' => [
                                'SSS' => $sss_to_pay,
                                'PHIC' => $hdmf_to_pay,
                                'HDMF' => $phic_to_pay,
                            ]
                        ]
                    ];
                // 


                // PAYSLIP
                    $new_payslip = new Payslip;
                    $new_payslip->user_id = $user->id;
                    $new_payslip->payroll_period_id = $payroll_period->id;
                    $new_payslip->cutoff_order = $cutoff_order;
                    $new_payslip->is_paid = false;
                    
                    $new_payslip->basic_pay = $raw_data['basic_pay'];
                    $new_payslip->gross_pay = $raw_data['gross_pay'];
                    $new_payslip->net_pay = $raw_data['net_pay'];
                    
                    $new_payslip->tardiness = $raw_data['tardiness_amount'];
                    $new_payslip->deductions = $raw_data['total_deductions'];

                    $new_payslip->taxable = $raw_data['taxable'];
                    $new_payslip->non_taxable = $raw_data['non_taxable'];
                    
                    $new_payslip->labels = json_encode($label_collection);
                    $new_payslip->save();


                    // new payslip deductions

                    $new_payslip_deductions = new PayslipDeduction;
                    $new_payslip_deductions->payslip_id = $new_payslip->id;
                    $new_payslip_deductions->tax_sss = $tax_sss;
                    $new_payslip_deductions->tax_hdmf = $tax_hdmf;
                    $new_payslip_deductions->tax_phic = $tax_phic;
                    $new_payslip_deductions->hdmf_loan = $hdmf_loan; 
                    $new_payslip_deductions->sss_loan = $sss_loan; 
                    $new_payslip_deductions->withholding_tax = $withholding_tax; 
                    $new_payslip_deductions->loan = $loan; 
                    $new_payslip_deductions->save(); 


                // 
            }
        }

        return 'success';
    }
}
