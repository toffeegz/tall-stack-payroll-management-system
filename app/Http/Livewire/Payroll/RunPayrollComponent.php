<?php

namespace App\Http\Livewire\Payroll;

use Livewire\Component;
use Illuminate\Http\Request;

class RunPayrollComponent extends Component
{
    public $payroll_period_id;

    public function render()
    {
        return view('livewire.payroll.run-payroll-component');
    }

    public function mount(Request $request)
    {
        $this->payroll_period_id  = $request->payroll_period;
        dd($this->payroll_period_id);
    }
}
