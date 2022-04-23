<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use App\Models\Loan;
use Livewire\WithPagination;

class UserRequestHistory extends Component
{
    use WithPagination;
    public $user_id;

    public $perPage = 5;

    public function render()
    {
        return view('livewire.loan.user-request-history', [
            'loans' => $this->loans
        ]);
    }
    
    public function getLoansProperty()
    {
        return Loan::where('user_id', $this->user_id)
        ->latest()
        ->paginate($this->perPage);
    }
}
