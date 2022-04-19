<?php

namespace App\Http\Livewire\Payroll;

use Livewire\Component;
use App\Models\PayrollPeriod;


class PayrollComponent extends Component
{
    public function render()
    {
        return view('livewire.payroll.payroll-component', ['latest_payroll_period' => $this->latestPayrollPeriod])
        ->layout('layouts.app',  ['menu' => 'payroll']);
    }

    public function getLatestPayrollPeriodProperty()
    {
        return PayrollPeriod::latest('period_end')->first();
    }

    public function submit()
    {
        return redirect()->route('payroll.run', [
            'payroll_period'  => $this->latestPayrollPeriod->id
        ]);
    }
}
