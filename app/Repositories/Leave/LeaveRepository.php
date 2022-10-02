<?php

namespace App\Repositories\Leave;

use App\Models\Leave;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class LeaveRepository extends BaseRepository implements LeaveRepositoryInterface
{

    /**
     * LeaveRepository constructor.
     *
     * @param Leave $model
     */

    public function __construct(Leave $model)
    {
        parent::__construct($model);
    }
}
