<?php

namespace App\Repositories\Loan;

use App\Models\Loan;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class LoanRepository extends BaseRepository implements LoanRepositoryInterface
{

    /**
     * LoanRepository constructor.
     *
     * @param Loan $model
     */

    public function __construct(Loan $model)
    {
        parent::__construct($model);
    }

    public function getLatestPendingLoanRequestByUser(string $id)
    {
        return $this->model->where('user_id', $id)->where('status', Loan::PENDING)->first();
    }

    public function getLoansWithBalanceByUser(string $id)
    {
        return $this->model->where('user_id', $id)
        ->where('balance', '!=', 0)
        ->where('status',Loan::APPROVED)
        ->get();
    }

    public function getBalanceByUser(string $id)
    {
        return $this->getLoansWithBalanceByUser($id)->sum('balance');
    }

    public function getAmountToPayByUser(string $id)
    {
        return $this->getLoansWithBalanceByUser($id)->sum('total_amount_to_pay');
    }

    public function getPaidByUser(string $id)
    {
        return $this->getAmountToPayByUser($id) - $this->getBalanceByUser($id);
    }

    public function getPaidPercentageByUser(string $id)
    {
        return round($this->getPaidByUser($id)  / $this->getAmountToPayByUser($id) * 100);
    }
}
