<?php

namespace App\Repositories\Attendance;

use App\Models\Attendance;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class AttendanceRepository extends BaseRepository implements AttendanceRepositoryInterface
{

    /**
     * AttendanceRepository constructor.
     *
     * @param Attendance $model
     */

    public function __construct(Attendance $model)
    {
        parent::__construct($model);
    }
}
