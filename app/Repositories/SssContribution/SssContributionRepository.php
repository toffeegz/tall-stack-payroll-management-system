<?php

namespace App\Repositories\SssContribution;

use App\Models\SssContributionModel;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class SssContributionRepository extends BaseRepository implements SssContributionRepositoryInterface
{

    /**
     * SssContributionRepository constructor.
     *
     * @param SssContributionModel $model
     */

    public function __construct(SssContributionModel $model)
    {
        parent::__construct($model);
    }
}
