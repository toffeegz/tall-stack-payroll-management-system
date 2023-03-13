<?php

namespace App\Repositories\Holiday;

use App\Models\Holiday;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class HolidayRepository extends BaseRepository implements HolidayRepositoryInterface
{

    /**
     * HolidayRepository constructor.
     *
     * @param Holiday $model
     */

    public function __construct(Holiday $model)
    {
        parent::__construct($model);
    }
}
