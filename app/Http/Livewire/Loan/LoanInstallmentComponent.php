<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\Loan\LoanInstallmentExport;

use App\Models\User;
use App\Models\Loan;
use App\Models\LoanInstallment;
use Carbon\Carbon;

class LoanInstallmentComponent extends Component
{
    use WithPagination;
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

    public function getLoanInstallmentsQueryProperty()
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
        ->latest('loan_installments.pay_date');
    }

    public function getLoanInstallmentsProperty()
    {
        return $this->loan_installments_query->paginate(10);
    }

    public function download()
    {
        $data = $this->loan_installments_query->get();
        $filename = Carbon::now()->format("Y-m-d") . " " . ' Loan Installment Export.xlsx';
        return Excel::download(new LoanInstallmentExport($data), $filename);
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
                $this->loan_balance = $user_found->loans->where('status',2)->sum('balance');
            }
            
        }
    }

    public function submitPayLoan()
    {
        $this->validate([
            'user_id' => 'required|numeric|min:0|not_in:0',
            'pay_date' => 'required|date|before:tomorrow',
        ]);

        $user_found = User::find($this->user_id);
        $loans_with_balance = Loan::where('user_id', $this->user_id)
        ->where('status', 2)
        ->where('balance', '!=', 0)
        ->get();


        if($loans_with_balance->sum('balance') >= 0) {
            $this->validate([
                'amount' => 'required|numeric|min:0|not_in:0',
            ]);
        } else {
            $this->validate([
                'amount' => 'required|numeric|max:0',
            ]);
        }

        

        if($this->amount > 0) {
            $change = $this->amount;

            foreach($loans_with_balance as $loan)
            {
                if($change >= 0) 
                {
                    $loan_balance = $loan->balance;
                    $amount = $change;
                    if($change == $loan_balance)
                    {
                        $change = 0;
                    } else
                    {
                        $change = $change - $loan_balance;
                    } 

                    
                    $loan_balance = $loan_balance - $amount; 
                    $loan->balance = $loan_balance;
                    if($loan->balance <= 0) {
                        $loan->pay_next = 0;
                    }
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

        } elseif ($this->amount < 0) {
            $change = $this->amount;

            foreach($loans_with_balance as $loan)
            {
                if($change < 0) 
                {
                    $loan_balance = $loan->balance;
                    $amount = $change;
                    if($change == $loan_balance)
                    {
                        $change = 0;
                    } else
                    {
                        $change = $change - $loan_balance;
                    } 

                    
                    $loan_balance = $loan_balance - $amount; 
                    $loan->balance = $loan_balance;
                    if($loan->balance <= 0) {
                        $loan->pay_next = 0;
                    }
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
        }

        $this->amount = 0;
        $this->user_id = 0;
        $this->pay_date = 0;
        $this->notes = 0;
        $this->loan_balance = 0;


        $this->emit('closePayLoanModal');
        $this->emit('openNotifModal');


    }

    public function openLoanDetails($value)
    {
        $this->selected_loan = $this->loanInstallments->find($value);
        $this->amount = $this->selected_loan->amount;
        $this->pay_date = $this->selected_loan->pay_date;
        $this->notes = $this->selected_loan->notes;
        $this->emit('openLoanDetailsModal');

    }

    public function updateLoanDetails()
    {
        $amount_paid_before = $this->selected_loan->amount;
        $balance_before_pay = $this->selected_loan->loan->balance + $amount_paid_before;
        $balance = $balance_before_pay - $this->amount;
        
        $this->selected_loan->loan->balance = $balance;
        $this->selected_loan->loan->save();

        $this->selected_loan->amount = $this->amount;
        $this->selected_loan->notes = $this->notes;
        $this->selected_loan->pay_date = $this->pay_date;
        $this->selected_loan->save();

        $this->emit('openNotifModal');
        $this->emit('closeLoanDetailsModal');

    }
    public function deleteLoan()
    {
        $amount_paid = $this->selected_loan->amount;
        $balance = $this->selected_loan->loan->balance + $amount_paid;
        
        $this->selected_loan->loan->balance = $balance;
        $this->selected_loan->loan->save();

        $this->selected_loan->delete();

        $this->emit('closeLoanDetailsModal');

    }
}
