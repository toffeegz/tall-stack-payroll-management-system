<?php

namespace App\Http\Livewire\Reports;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;

use App\Exports\Report\PayrollSummaryExport;
use App\Exports\Report\TaxContributionExport;
use App\Exports\Report\LoanExport;
use App\Exports\Report\EmployeeListExport;
use App\Exports\Report\PayrollJournalExport;


use App\Models\PayrollPeriod;
use App\Models\Project;

use App\Models\Payslip;
use App\Models\TaxContribution;
use App\Models\Loan;
use App\Models\User;

use Carbon\Carbon;

class ReportComponent extends Component
{
    public $frequency_id = 1;
    public $payroll_period = "";
    public $message;

    public $start_date, $end_date;
    public $user_type = "";
    public $project = "";

    public function render()
    {
        return view('livewire.reports.report-component',[
            'payroll_periods' => $this->payroll_periods,
            'projects' => $this->projects,
        ])
        ->layout('layouts.app',  ['menu' => 'reports']);
    }

    public function getPayrollPeriodsProperty()
    {
        return PayrollPeriod::latest('period_end')
        ->where('frequency_id', $this->frequency_id)
        ->get();
    }

    public function getProjectsProperty()
    {
        return Project::all();
    }



    // SUBMIT AND GENERATE

    public function generatePayrollSummaryReport()
    {
        $this->validate([
            'payroll_period'=>'required'
        ]);
        $raw_data = Payslip::where('payroll_period_id', $this->payroll_period)->get();

        if($raw_data->count() != 0)
        { 
            $payroll_period = PayrollPeriod::find($this->payroll_period);
            $data = [
                'period_start' => $payroll_period->period_start,
                'period_end' => $payroll_period->period_end,
                'payout_date' => $payroll_period->payout_date,
                'frequency_id' => $payroll_period->frequency_id,
            ];

            $filename = Carbon::now()->format('Ymd') . ' Payroll Summary.xlsx';
            return Excel::download(new PayrollSummaryExport($data, $raw_data), $filename);
        }
        else
        {
            $this->emit('openNotifModal');
        }

        
    }

    public function generateTaxContributionReport()
    {
        $this->validate([
            'payroll_period'=>'required'
        ]);
        $raw_data = TaxContribution::where('payroll_period_id', $this->payroll_period)
        ->orderBy('tax_type', 'asc')
        ->get()
        ->groupBy('user_id');

        if($raw_data->count() != 0)
        { 
            $payroll_period = PayrollPeriod::find($this->payroll_period);
            $data = [
                'period_start' => $payroll_period->period_start,
                'period_end' => $payroll_period->period_end,
                'payout_date' => $payroll_period->payout_date,
                'frequency_id' => $payroll_period->frequency_id,
            ];
            $filename = Carbon::now()->format('Ymd') . ' Tax Contribution.xlsx';
            $this->emit('closeTaxContributionModal');

            return Excel::download(new TaxContributionExport($data, $raw_data), $filename);
        }
        else
        {
            
            $this->emit('closeTaxContributionModal');
            $this->emit('openNotifModal');
        }

        
    }

    public function generateLoanReport()
    {
        $this->validate([
            'start_date'  =>  'date|nullable|before:tomorrow',
            'end_date'    =>  'date|nullable|after_or_equal:start_date|before:tomorrow'
        ]);
        $start_date = $this->start_date;
        $end_date = $this->end_date;
        $raw_data = Loan::query()
        ->where(function ($query) use ($start_date, $end_date){
            if($start_date && $end_date) {
                return $query->whereBetween('created_at',[$start_date, $end_date]);
            } elseif($start_date) {
                return $query->where('created_at', '>=', $start_date);
            } elseif($end_date) {
                return $query->where('created_at', '<=', $end_date);
            }
        })
        ->get();

        if($raw_data->count() != 0)
        { 
            $payroll_period = PayrollPeriod::find($this->payroll_period);
            $data = [
                'period_start' => $start_date,
                'period_end' => $end_date,
            ];
            $filename = Carbon::now()->format('Ymd') . ' Loan Cash Advance.xlsx';
            $this->emit('closeLoanModal');

            return Excel::download(new LoanExport($data, $raw_data), $filename);
        }
        else
        {
            
            $this->emit('closeTaxContributionModal');
            $this->emit('openNotifModal');
        }
    }

    public function generateEmployeeListReport()
    {
        if($this->user_type == ""){
            $raw_data = User::all();
        } elseif($this->user_type == 1) {
            $raw_data = User::doesntHave('projects')->get();
        } elseif($this->user_type == 2) {
            if($this->project == "") {
                $raw_data = Project::all();
            } else {
                $raw_data = Project::find($this->project);
            }
        }
        if($raw_data->count() != 0)
        { 
            $data = [
                'user_type' => $this->user_type,
                'project' => $this->project,
            ];
            $filename = Carbon::now()->format('Ymd') . ' Employee List.xlsx';
            $this->emit('closeEmployeeListModal');

            return Excel::download(new EmployeeListExport($data, $raw_data), $filename);
        }
        else
        {
            
            $this->emit('closeEmployeeListModal');
            $this->emit('openNotifModal');
        }
    }
}
