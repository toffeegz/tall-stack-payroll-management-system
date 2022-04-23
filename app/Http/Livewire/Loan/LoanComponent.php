<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

use App\Models\LoanInstallment;
use App\Models\Loan;

class LoanComponent extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $pending_request;
    public $total_balance;
    public $total_amount_to_pay;
    public $paid_percentage;

    public $amount = 3000;
    public $installment_amount = 0;
    public $install_period = 2;
    public $details = "";

    public function mount()
    {
        $this->pending_request = Loan::where('user_id', Auth::user()->id)
        ->where('status', 1)
        ->first();

        $loans_with_balance = Loan::where('user_id', Auth::user()->id)
        ->where('status', 2)->get();

        $this->total_balance = $loans_with_balance->sum('balance');

        if($this->total_balance != 0)
        {
            $this->total_amount_to_pay = $loans_with_balance->sum('total_amount_to_pay');

            $this->paid_percentage = round($this->total_balance / $this->total_amount_to_pay * 100);
        }
        

        $this->existing_loan = Loan::where('user_id', Auth::user()->id)
        ->where('status', 2)
        ->where('balance', '!=', 0)
        ->first();

        Self::getInstallmentAmountValue();

    }

    public function render()
    {
        return view('livewire.loan.loan-component',[
            'loans' => $this->loans,
            'loan_installments' => $this->loanInstallments,
        ])
        ->layout('layouts.app',  ['menu' => 'loan']);
    }

    public function getLoanInstallmentsProperty()
    {
        return LoanInstallment::where('user_id', Auth::user()->id)
        ->latest()
        ->paginate($this->perPage);
    }

    public function getLoansProperty()
    {
        return Loan::where('user_id', Auth::user()->id)
        ->latest()
        ->paginate($this->perPage);
    }


    public function cancelRequest()
    {
        $this->pending_request->delete();
        // $this->emit('closeNotifModal');
        return redirect()->route('loan');

    }

    public function updatedAmount()
    {
        if($this->amount != ""){
            Self::getInstallmentAmountValue();
        }
    }

    
    public function updatedInstallPeriod()
    {
        Self::getInstallmentAmountValue();
    }

    public function getInstallmentAmountValue()
    {
        $this->installment_amount = $this->amount / $this->install_period;
    }

    public function requestLoan()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1000|max:10000|',
            'install_period' => 'required|numeric|min:1|not_in:0',
            'installment_amount' => 'required|min:0|not_in:0',
            'details' => 'required',
        ]);

        $new_loan = new Loan;
        $new_loan->loan_type_id = 1;
        $new_loan->user_id = Auth::user()->id;
        $new_loan->amount = $this->amount;
        $new_loan->total_amount_to_pay = $this->amount;
        $new_loan->balance = $this->amount;
        $new_loan->pay_next = $this->installment_amount;
        $new_loan->installment_amount = $this->installment_amount;
        $new_loan->details = $this->details;
        $new_loan->status = 1;
        $new_loan->auto_deduct = false;
        $new_loan->install_period = $this->install_period;
        $new_loan->save();

        $this->emit('openNotifModal');

        return redirect()->route('loan');

    }
    
}
