<?php

namespace App\Repositories\LeaveType;

use App\Models\LeaveType;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class LeaveTypeRepository extends BaseRepository implements LeaveTypeRepositoryInterface
{

    /**
     * LeaveTypeRepository constructor.
     *
     * @param LeaveType $model
     */

    public function __construct(LeaveType $model)
    {
        parent::__construct($model);
    }
}
