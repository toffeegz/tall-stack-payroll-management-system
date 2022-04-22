<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use App\Models\User;
use App\Models\Loan;
use App\Models\LoanInstallment;
use Carbon\Carbon;

class LoanInstallmentComponent extends Component
{
    public $search = "";
    public $perPage = 5;

    public $user_id = "";
    public $amount = 1000;
    public $pay_date = "";
    public $notes = "";

    public $loan_balance = 0;

    public $selected_loan_installment = null;

    public function mount()
    {
        
    }

    public function render()
    {
        return view('livewire.loan.loan-installment-component', [
            'loan_installments' => $this->loanInstallments,
            'users' => $this->users,
        ])
        ->layout('layouts.app',  ['menu' => 'loan-installment']);
    }

    public function getLoanInstallmentsProperty()
    {
        $search = $this->search;

        return LoanInstallment::query()
        ->leftJoin('users', 'users.id', '=', 'loan_installments.user_id')
        ->where(function ($query) use ($search) {
            return $query->where('users.last_name', 'like', '%' . $search . '%')
            ->orWhere('users.first_name', 'like', '%' . $search . '%')
            ->orWhere('users.code', 'like', '%' . $search . '%');
        })
        ->select('loan_installments.*', 'users.id as user_id')
        ->latest('loan_installments.updated_at')
        ->paginate($this->perPage);
    }
    
    public function getUsersProperty()
    {
        $keyword = 0;
        return User::whereHas('loans', function ($query) use ($keyword) {
            $query->where('balance', '!=', 0)->where('status', 2);
        })
        ->get();
    }

    public function updatingUserId($value)
    {
        if($value != "")
        {
            $user_found = User::find($value);
            if($user_found){
                $this->loan_balance = $user_found->loans->sum('balance');
            }
            
        }
    }

    public function submitPayLoan()
    {
        $this->validate([
            'user_id' => 'required|numeric|min:0|not_in:0',
            'amount' => 'required|numeric|min:0|not_in:0',
            'pay_date' => 'required|date|before:tomorrow',
        ]);

        $user_found = User::find($this->user_id);
        $loans_with_balance = Loan::where('user_id', $this->user_id)
        ->where('status', 2)
        ->where('balance', '!=', 0)
        ->get();

        $change = $this->amount;

        foreach($loans_with_balance as $loan)
        {
            if($change != 0) 
            {
                $loan_balance = $loan->balance;
                $amount = $change;
                if($change == $loan_balance)
                {
                    $change = 0;
                } elseif($change > $loan_balance)
                {
                    $change = $change - $loan_balance;
                } 

                
                $loan_balance = $loan_balance - $amount; 
                $loan->balance = $loan_balance;
                $loan->save();

                $new_loan_installment = new LoanInstallment;
                $new_loan_installment->loan_id = $loan->id;
                $new_loan_installment->user_id = $this->user_id;
                $new_loan_installment->amount = $amount;
                $new_loan_installment->pay_date = $this->pay_date;
                $new_loan_installment->notes = $this->notes;
                $new_loan_installment->save();
            } else {
                break;
            }
        }

        $this->amount = 0;
        $this->user_id = 0;
        $this->pay_date = 0;
        $this->notes = 0;
        $this->loan_balance = 0;


        $this->emit('closePayLoanModal');
        $this->emit('openNotifModal');


    }
}
