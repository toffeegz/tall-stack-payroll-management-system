<?php

namespace App\Repositories\Schedule;

use App\Models\Schedule;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class ScheduleRepository extends BaseRepository implements ScheduleRepositoryInterface
{

    /**
     * ScheduleRepository constructor.
     *
     * @param Schedule $model
     */

    public function __construct(Schedule $model)
    {
        parent::__construct($model);
    }
}
