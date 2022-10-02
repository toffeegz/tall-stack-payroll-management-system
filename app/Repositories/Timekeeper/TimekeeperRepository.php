<?php

namespace App\Repositories\Timekeeper;

use App\Models\Timekeeper;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class TimekeeperRepository extends BaseRepository implements TimekeeperRepositoryInterface
{

    /**
     * TimekeeperRepository constructor.
     *
     * @param Timekeeper $model
     */

    public function __construct(Timekeeper $model)
    {
        parent::__construct($model);
    }
}
