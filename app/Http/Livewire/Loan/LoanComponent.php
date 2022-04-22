<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;


class LoanComponent extends Component
{
    public function mount()
    {
        
    }

    public function render()
    {
        return view('livewire.loan.loan-component')
        ->layout('layouts.app',  ['menu' => 'loan']);
    }
}
