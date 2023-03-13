<?php

namespace App\Http\Livewire\Payroll;

use Livewire\Component;
use Illuminate\Http\Request;

use App\Models\PayrollLog;

use App\Classes\Payroll\PayrollClass;
use App\Classes\Payroll\PayslipClass;
use App\Services\PayrollPeriod\PayrollPeriodServiceInterface;
use App\Services\Payslip\PayslipServiceInterface;
use App\Repositories\PayrollPeriod\PayrollPeriodRepositoryInterface;

use App\Models\PayrollPeriod;
use App\Models\User;

use App\Jobs\Payslip\GeneratePayslipJob;


class ReviewProcessedPayrollComponent extends Component
{
    public $payroll_logs_id;
    public $payroll_logs;
    public $payrolls;

    public $period_start;
    public $period_end;
    public $payout_date;

    public $payroll_period_id;
    
    public $selected_user_id;
    public $selected_user_name;
    public $sss_amount = 0, $hdmf_amount = 0, $phic_amount= 0; 
    public $total_tax_contributions;

    private $payrollPeriodService;
    private $payslipService;
    private $payrollPeriodRepository;
    public function boot(
        PayrollPeriodServiceInterface $payrollPeriodService,
        PayslipServiceInterface $payslipService,
        PayrollPeriodRepositoryInterface $payrollPeriodRepository,
    ) {
        $this->payrollPeriodService = $payrollPeriodService;
        $this->payslipService = $payslipService;
        $this->payrollPeriodRepository = $payrollPeriodRepository;
    }

    public function mount(Request $request)
    {
        $this->payroll_logs_id = $request->id;
        $this->payroll_logs = PayrollLog::find($this->payroll_logs_id);
        if($this->payroll_logs)
        {
            $data = $this->payroll_logs;
            $this->payrolls = $this->payrollPeriodService->payroll($data);
            // dd($this->payrolls);
        }
        else{
            return abort(404);
        }
        
        $payroll_period = PayrollPeriod::where('period_start', $this->payroll_logs->period_start)
        ->where('period_end', $this->payroll_logs->period_end)
        ->first();
        $this->period_start = $payroll_period->period_start;
        $this->period_end = $payroll_period->period_end;
        $this->payout_date = $payroll_period->payout_date;
        $this->payroll_period_id = $payroll_period->id;


        // 
        $this->total_tax_contributions = 0;

    }

    public function render()
    {
        return view('livewire.payroll.review-processed-payroll-component',[
            'total_net_pay' => $this->totalNetPay,
        ])
        ->layout('layouts.app',  ['menu' => 'payroll']);
    }

    public function getTotalNetPayProperty()
    {
        $net_pay = 0;
        foreach($this->payrolls as $data)
        {
            $net_pay += $data['net_pay'];
        }
        return $net_pay;
    }

    public function editTaxContribution($user_id)
    {
        $this->selected_user_id = $user_id;
        $user = User::find($user_id);
        $this->selected_user_name = $user->formal_name();

        $data = $this->payrolls[$user_id]['deductions_collection']['tax_contribution'];
        // dd($data);
        $this->sss_amount = $data['sss_contribution']['ee'];
        $this->hdmf_amount = $data['hdmf_contribution']['total_ee'];
        $this->phic_amount = $data['phic_contribution']['total_ee'];

        $this->total_tax_contributions = $this->sss_amount + $this->hdmf_amount + $this->phic_amount;
        $this->emit('openEditTaxContributionsModal');
    }

    public function submitTaxContributions()
    {
        $data = $this->payrolls[$this->selected_user_id]['deductions_collection']['tax_contribution'];

        if($this->sss_amount == "")
        {
            $this->sss_amount = 0;
        }
        if($this->hdmf_amount == "")
        {
            $this->hdmf_amount = 0;
        }
        if($this->phic_amount == "")
        {
            $this->phic_amount = 0;
        }
        $total_tax_contributions = $this->sss_amount + $this->hdmf_amount + $this->phic_amount;

        $this->payrolls[$this->selected_user_id]['tax_contributions'] = $total_tax_contributions;
        $this->payrolls[$this->selected_user_id]['deductions_collection']['tax_contribution']['sss_contribution']['ee'] = $this->sss_amount;
        $this->payrolls[$this->selected_user_id]['deductions_collection']['tax_contribution']['hdmf_contribution']['total_ee'] = $this->hdmf_amount;
        $this->payrolls[$this->selected_user_id]['deductions_collection']['tax_contribution']['phic_contribution']['total_ee'] = $this->phic_amount;

        $this->payrolls[$this->selected_user_id]['total_deductions'] = $this->payrolls[$this->selected_user_id]['loan_deductions'] + $this->payrolls[$this->selected_user_id]['tardiness_amount'] + $this->payrolls[$this->selected_user_id]['tax_contributions'];
        $this->payrolls[$this->selected_user_id]['net_pay'] = $this->payrolls[$this->selected_user_id]['gross_pay'] - $this->payrolls[$this->selected_user_id]['total_deductions'];

        $this->emit('closeEditTaxContributionsModal');

    }

    public function submitPayroll()
    {
        // $result = $this->payslipService->generate($this->payrolls);
        GeneratePayslipJob::dispatch($this->payrolls);
        $payroll_period = $this->payrollPeriodRepository->show($this->payroll_period_id);
        $payroll_period->is_payroll_generated = true;
        $payroll_period->save();
        return redirect()->route('payroll');
    }
}
