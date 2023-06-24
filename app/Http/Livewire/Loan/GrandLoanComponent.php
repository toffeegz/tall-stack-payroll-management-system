<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\User;
use App\Models\Loan;
use App\Models\LoanInstallment;
use App\Exports\Loan\GrandLoanExport;

use Carbon\Carbon;

class GrandLoanComponent extends Component
{
    use WithPagination;

    public $search = "";
    public $perPage = 10;
    public $status;

    // 
    public $selected_loan = null;
    public $selected_status = "";
    public $selected_amount = 0;
    public $selected_installment_amount = 0;
    public $selected_balance = 0;
    public $selected_install_period = 2;
    public $selected_auto_deduct = false;
    public $selected_total_amount_to_pay = 0;
    public $selected_project_id = "";
    public $selected_user = null;
    public $selected_reference_no = null;

    // new
    public $new_amount = 0;
    public $new_status = 1;
    public $new_user_id = 0;
    public $new_project_id = 0;
    public $new_installment_amount = 0;
    public $new_install_period = 2;
    public $new_auto_deduct = false;
    public $new_reference_no = null;

    public $projects = [];

    public function render()
    {
        return view('livewire.loan.grand-loan-component', [
            'loans' => $this->loans,
            'users' => $this->users,
        ])
        ->layout('layouts.app',  ['menu' => 'grand-loan']);
    }

    public function getUsersProperty()
    {
        return User::where('is_active', true)->get();
    }

    public function getLoansQueryProperty()
    {
        $status = $this->status;
        $search = $this->search;

        return Loan::query()
        ->where(function ($query) use ($status) {
            if($status != "") {
                return $query->where('loans.status', $status);
            }
        })
        ->leftJoin('users', 'users.id', '=', 'loans.user_id')
        ->where(function ($query) use ($search) {
            return $query->where('users.last_name', 'like', '%' . $search . '%')
            ->orWhere('users.first_name', 'like', '%' . $search . '%')
            ->orWhere('users.code', 'like', '%' . $search . '%');
        })
        ->select('loans.*', 'users.id as user_id')
        ->latest('loans.created_at');
    }

    public function getLoansProperty()
    {
        return $this->loans_query->paginate($this->perPage);
    }

    public function download()
    {
        $data = $this->loans_query->get();
        $filename = Carbon::now()->format("Y-m-d") . " " . ' Grant Loan Export.xlsx';
        return Excel::download(new GrandLoanExport($data), $filename);
    }

    public function openLoanDetails($id)
    {
        $this->selected_loan = $this->loans->find($id);
        $this->selected_status = $this->selected_loan->status;
        $this->selected_amount = $this->selected_loan->amount;
        $this->selected_installment_amount = $this->selected_loan->installment_amount;
        $this->selected_install_period = $this->selected_loan->install_period;
        $this->selected_auto_deduct = $this->selected_loan->auto_deduct;
        $this->selected_project_id = $this->selected_loan->project_id;
        $this->selected_reference_no = $this->selected_loan->reference_no;
        $this->selected_user = User::find($this->selected_loan->user_id);
        
        $this->emit('openLoanDetailsModal');
    }

    public function updatedSelectedAmount()
    {
        Self::getInstallmentAmount();
    }

    public function updatedSelectedInstallPeriod()
    {
        Self::getInstallmentAmount();
    }

    public function updatedNewAmount()
    {
        Self::getNewInstallmentAmount();
    }

    public function updatedNewInstallPeriod()
    {
        Self::getNewInstallmentAmount();
    }

    public function getInstallmentAmount()
    {
        if($this->selected_amount != "") {
            $this->selected_installment_amount = $this->selected_amount / $this->selected_install_period;
        }
        
    }

    public function getNewInstallmentAmount()
    {
        if($this->new_amount != "") {
            $this->new_installment_amount = $this->new_amount / $this->new_install_period;
        }
    }

    public function updateLoanDetails()
    {
        $this->validate([
            'selected_status' => 'required|numeric|min:0|not_in:0',
            'selected_amount' => 'required|numeric|min:0|not_in:0',
            'selected_install_period' => 'required|numeric|min:0|not_in:0',
            'selected_installment_amount' => 'required|numeric|min:0|not_in:0',
            'selected_reference_no' => 'required|max:50'
        ]);

        $paid_amount = $this->selected_loan->loanInstallments->sum('amount');
        $balance = $this->selected_amount - $paid_amount;

        $date_approved = null;
        if($this->selected_status == 2)
        {
            $date_approved = Carbon::now();
        }

        $this->selected_loan->status = $this->selected_status;
        $this->selected_loan->amount = $this->selected_amount;
        $this->selected_loan->installment_amount = $this->selected_installment_amount;
        
        $this->selected_loan->install_period = $this->selected_install_period;
        $this->selected_loan->auto_deduct = $this->selected_auto_deduct;
        $this->selected_loan->total_amount_to_pay = $this->selected_amount;
        $this->selected_loan->balance = $balance;
        $this->selected_loan->date_approved = $date_approved;
        $this->selected_loan->project_id = $this->selected_project_id;
        $this->selected_loan->reference_no = $this->selected_reference_no;
        $this->selected_loan->save();

        $this->emit('closeLoanDetailsModal');

    }

    public function updatingNewUserId($value)
    {
        $user = User::find($value);
        if($user){
            $this->projects = $user->projects;
        }
    }

    public function submitLoan()
    {
        $this->validate([
            'new_user_id' => 'required|numeric',
            'new_project_id' => 'nullable|numeric',
            'new_status' => 'required|numeric|min:0|not_in:0',
            'new_amount' => 'required|numeric|min:0|not_in:0',
            'new_install_period' => 'required|numeric|min:0|not_in:0',
            'new_installment_amount' => 'required|numeric|min:0|not_in:0',
            'new_reference_no' => 'required|max:50',
        ]);

        $date_approved = null;
        if($this->new_status == 2)
        {
            $date_approved = Carbon::now();
        }

        $new_loan = new Loan;
        $new_loan->loan_type_id = 1;
        $new_loan->user_id = $this->new_user_id;
        $new_loan->project_id = $this->new_project_id;
        $new_loan->amount = $this->new_amount;
        $new_loan->total_amount_to_pay = $this->new_amount;
        $new_loan->balance = $this->new_amount;
        $new_loan->pay_next = $this->new_installment_amount;
        $new_loan->installment_amount = $this->new_installment_amount;
        $new_loan->reference_no = $this->new_reference_no;
        $new_loan->date_approved = $date_approved;
        $new_loan->status = $this->new_status;
        $new_loan->auto_deduct = $this->new_auto_deduct;
        $new_loan->install_period = $this->new_install_period;
        $new_loan->save();

        $this->emit('closeGrantLoanModal');
    }

    public function deleteLoan()
    {
        $this->selected_loan->delete();
        $this->emit('closeLoanDetailsModal');

    }

}
