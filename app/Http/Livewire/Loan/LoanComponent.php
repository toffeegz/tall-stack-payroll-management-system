<?php

namespace App\Http\Livewire\Loan;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\Loan\PaymentHistoryExport;
use App\Exports\Loan\RequestHistoryExport;

use App\Models\LoanInstallment;
use App\Models\Loan;
use App\Repositories\Loan\LoanRepositoryInterface;

use Carbon\Carbon;

class LoanComponent extends Component
{
    use WithPagination;

    public $perPage = 5;

    public $pending_request;
    public $total_balance = 0;
    public $total_amount_to_pay = 0;
    public $total_paid = 0;
    public $paid_percentage;

    public $amount = 3000;
    public $installment_amount = 0;
    public $install_period = 2;
    public $details = "";

    protected $modelRepository;
    public function boot(
        LoanRepositoryInterface $modelRepository
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function mount()
    {
        $auth_id = Auth::user()->id;
        $this->pending_request = $this->modelRepository->getLatestPendingLoanRequestByUser($auth_id);
        $this->total_balance = $this->modelRepository->getBalanceByUser($auth_id);

        if($this->total_balance != 0)
        {
            $this->total_amount_to_pay = $this->modelRepository->getAmountToPayByUser($auth_id);
            $this->total_paid = $this->modelRepository->getPaidByUser($auth_id);
            $this->paid_percentage = $this->modelRepository->getPaidPercentageByUser($auth_id);
        }

        $this->existing_loan = $this->modelRepository->getLoansWithBalanceByUser($auth_id);
        Self::getInstallmentAmountValue();

    }

    public function render()
    {
        return view('livewire.loan.loan-component')
        ->layout('layouts.app',  ['menu' => 'loan']);
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

    // DOWNLOAD

    public function downloadPaymentHistory()
    {
        $data = LoanInstallment::where('user_id', Auth::user()->id)
        ->latest('pay_date')
        ->get();

        $filename = Carbon::now()->format("Y-m-d") . " " . Auth::user()->code . " " . ' Payment History.xlsx';
        return Excel::download(new PaymentHistoryExport($data), $filename);
    }

    public function downloadRequestHistory()
    {
        $data = Loan::where('user_id', Auth::user()->id)
        ->latest()
        ->get();

        $filename = Carbon::now()->format("Y-m-d") . " " . Auth::user()->code . " " . ' Request History.xlsx';
        return Excel::download(new RequestHistoryExport($data), $filename);
    }
    
}
