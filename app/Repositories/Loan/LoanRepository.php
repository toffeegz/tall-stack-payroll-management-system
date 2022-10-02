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
}
