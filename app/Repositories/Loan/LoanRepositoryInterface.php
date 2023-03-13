<?php

namespace App\Repositories\Loan;

use App\Repositories\Base\BaseRepositoryInterface;

interface LoanRepositoryInterface extends BaseRepositoryInterface
{
    public function getLoansWithBalanceByUser(string $id);
    public function getBalanceByUser(string $id);
    public function getAmountToPayByUser(string $id);
    public function getPaidByUser(string $id);
    public function getPaidPercentageByUser(string $id);
}
