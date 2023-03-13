<?php

namespace App\Repositories\PayrollLog;

use App\Models\PayrollLog;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class PayrollLogRepository extends BaseRepository implements PayrollLogRepositoryInterface
{

    /**
     * PayrollLogRepository constructor.
     *
     * @param PayrollLog $model
     */

    public function __construct(PayrollLog $model)
    {
        parent::__construct($model);
    }
}
