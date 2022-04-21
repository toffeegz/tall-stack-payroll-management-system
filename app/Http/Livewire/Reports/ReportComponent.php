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

use App\Models\Payslip;
use App\Models\PayrollPeriod;

use Carbon\Carbon;

class ReportComponent extends Component
{
    public $ps_frequency_id = 1;
    public $ps_payroll_period = "";

    public function render()
    {
        return view('livewire.reports.report-component',[
            'payroll_periods' => $this->payroll_periods,
        ])
        ->layout('layouts.app',  ['menu' => 'reports']);
    }

    public function getPayrollPeriodsProperty()
    {
        return PayrollPeriod::latest('period_end')
        ->where('frequency_id', $this->ps_frequency_id)
        ->get();
    }

    public function generatePayrollSummaryReport()
    {
        $this->validate([
            'ps_payroll_period'=>'required'
        ]);
        $raw_data = Payslip::where('payroll_period_id', $this->ps_payroll_period)->get();

        if($raw_data->count() != 0)
        { 
            $payroll_period = PayrollPeriod::find($this->ps_payroll_period);
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
            dd('no data');
        }

        
    }
}
