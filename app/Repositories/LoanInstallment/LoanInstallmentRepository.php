<?php

namespace App\Repositories\LoanInstallment;

use App\Models\LoanInstallment;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class LoanInstallmentRepository extends BaseRepository implements LoanInstallmentRepositoryInterface
{

    /**
     * LoanInstallmentRepository constructor.
     *
     * @param LoanInstallment $model
     */

    public function __construct(LoanInstallment $model)
    {
        parent::__construct($model);
    }
}
