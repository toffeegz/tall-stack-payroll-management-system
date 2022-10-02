<?php

namespace App\Repositories\SssContributionRate;

use App\Models\SssContributionRate;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class SssContributionRateRepository extends BaseRepository implements SssContributionRateRepositoryInterface
{

    /**
     * SssContributionRateRepository constructor.
     *
     * @param SssContributionRate $model
     */

    public function __construct(SssContributionRate $model)
    {
        parent::__construct($model);
    }
}
