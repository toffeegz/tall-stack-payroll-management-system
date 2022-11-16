<?php

namespace App\Http\Livewire\Payroll;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Classes\Payroll\PayslipClass;
use App\Exports\Report\UserPayslipExport;

use App\Models\Payslip;
use App\Models\PayrollPeriod;
use App\Services\Payslip\PayslipServiceInterface;

use Carbon\Carbon;

class PayslipComponent extends Component
{
    public $perPage = 10;


    public $selected_payslip = null;

    public $payout_date = null;
    public $pay_period = null;
    public $basic_pay = null;
    public $basic_pay_hours = null;
    public $overtime_pay = null;
    public $overtime_hours = null;
    public $restday_pay = null;
    public $restday_hours = null;
    public $restday_ot_pay = null;
    public $restday_ot_hours = null;
    public $night_differential_pay = null;
    public $night_differential_hours = null;

    public $holiday_pay = null;
    public $others_pay = null;

    public $gross_pay = null;

    public $late = null;
    public $undertime = null;
    public $absences = null;
    public $cash_advance = null;
    public $sss_loan = null;
    public $hdmf_loan = null;
    public $tax_contribution = null;
    public $sss = null;
    public $phic = null;
    public $hdmf = null;

    public $late_hours = null;
    public $undertime_hours = null;

    public $deductions = null;

    private $payslipService;
    public function boot(
        PayslipServiceInterface $payslipService,
    ) {
        $this->payslipService = $payslipService;
    }

    public function mount()
    {
        $this->selected_payslip = $this->payslips->first();
        if($this->selected_payslip)
        {
            Self::payslipUpdate();

        }
        
        
    }

    public function render()
    {
        return view('livewire.payroll.payslip-component',[
            'payslips' => $this->payslips,
            'payroll_periods' => $this->payrollPeriods,
        ])->layout('layouts.app',  ['menu' => 'payslip']);
    }

    public function getPayslipsProperty()
    {
        return Payslip::where('user_id', Auth::user()->id)
        ->latest('created_at')
        ->paginate($this->perPage);
    }

    public function getPayrollPeriodsProperty()
    {
        return PayrollPeriod::where('frequency_id', Auth::user()->frequency_id)
        ->where('is_payroll_generated', true)
        ->get();
    }

    public function selectPayslip($value)
    {
        $this->selected_payslip = Payslip::find($value);
        Self::payslipUpdate();
    }

    public function payslipUpdate()
    {
        $this->payout_date = Carbon::parse($this->selected_payslip->payroll_period->payout_date)->format('F d, Y');
        $this->pay_period = Carbon::parse($this->selected_payslip->payroll_period->period_start)->format('M d') . " - " . Carbon::parse($this->selected_payslip->payroll_period->period_end)->format('M d');
        
        $labels = json_decode($this->selected_payslip->labels, true);
        $this->basic_pay = $this->selected_payslip->basic_pay;
        $this->basic_pay_hours = $labels['hours']['regular'];

        $this->overtime_pay =  $labels['earnings']['overtime_pay'];
        $this->overtime_hours =  $labels['hours']['overtime'];

        $this->restday_pay =  $labels['earnings']['restday_pay'];
        $this->restday_hours =  $labels['hours']['restday'];

        $this->restday_ot_pay =  $labels['earnings']['restday_ot_pay'];
        $this->restday_ot_hours =  $labels['hours']['restday_ot'];

        $this->night_differential_pay =  $labels['earnings']['night_diff_pay'];
        $this->night_differential_hours =  $labels['hours']['night_differential'];

        $label_holiday = $labels['earnings']['holiday'];
        foreach($label_holiday as $holiday)
        {
            $this->holiday_pay += $holiday;
        }

        $label_others = $labels['earnings']['others'];
        foreach($label_others as $other)
        {
            $this->others_pay += $other;
        }

        $this->gross_pay = $this->selected_payslip->gross_pay;

        // DEDUCTIONS
        $label_deductions = $labels['deductions'];

        $this->late_hours = $labels['hours']['late'];
        $this->undertime_hours = $labels['hours']['undertime'];

        $this->late = $label_deductions['late'];
        $this->undertime = $label_deductions['undertime'];
        $this->absences = $label_deductions['absences'];
        $this->cash_advance = $label_deductions['cash_advance'];
        $this->sss_loan = $label_deductions['sss_loan'];
        $this->hdmf_loan = $label_deductions['hdmf_loan'];
        $this->sss = $label_deductions['tax_contribution']['sss'];
        $this->phic = $label_deductions['tax_contribution']['phic'];
        $this->hdmf = $label_deductions['tax_contribution']['hdmf'];

        $this->deductions = $this->selected_payslip->deductions;
    }

    public function downloadPayslip()
    {
        
        $data = $this->payslipService->payslipViewDataVariable($this->selected_payslip);
        $filename = Carbon::parse($this->selected_payslip->payout_date)->format('M d Y') . ' Payslip.xlsx';
        return Excel::download(new UserPayslipExport($data), $filename);
    }
}
