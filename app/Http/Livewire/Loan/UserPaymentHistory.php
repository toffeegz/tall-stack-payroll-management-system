<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use App\Models\LoanInstallment;
use Livewire\WithPagination;

class UserPaymentHistory extends Component
{
    use WithPagination;

    public $user_id;

    public $perPage = 5;

    public function render()
    {
        return view('livewire.loan.user-payment-history', [
            'loan_installments' => $this->loanInstallments,
        ]);
    }

    public function getLoanInstallmentsProperty()
    {
        return LoanInstallment::where('user_id', $this->user_id)
        ->latest('pay_date')
        ->paginate($this->perPage);
    }
}
