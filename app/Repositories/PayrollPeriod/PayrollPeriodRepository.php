<?php

namespace App\Repositories\PayrollPeriod;

use App\Models\PayrollPeriod;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class PayrollPeriodRepository extends BaseRepository implements PayrollPeriodRepositoryInterface
{

    /**
     * PayrollPeriodRepository constructor.
     *
     * @param PayrollPeriod $model
     */

    public function __construct(PayrollPeriod $model)
    {
        parent::__construct($model);
    }
}
