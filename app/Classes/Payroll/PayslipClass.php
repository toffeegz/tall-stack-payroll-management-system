<?php

namespace App\Classes\Payroll;

use App\Jobs\Payroll\PayslipJob;
use Carbon\Carbon;
use App\Models\User;

class PayslipClass {

    public function payslipCreation($data)
    {
        foreach($data as $payslip)
        {
            PayslipJob::dispatch($payslip)
            ->delay(now()->addSeconds(15));
        }

        return 'success';
    }

    public function payslipViewDataVariable($payslip)
    {
        

        $payout_date = Carbon::parse($payslip->payroll_period->payout_date)->format('F d, Y');
        $pay_period = Carbon::parse($payslip->payroll_period->period_start)->format('M d') . " - " . Carbon::parse($payslip->payroll_period->period_end)->format('M d');
        
        $labels = json_decode($payslip->labels, true);

        $user = User::find($payslip->user_id);
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