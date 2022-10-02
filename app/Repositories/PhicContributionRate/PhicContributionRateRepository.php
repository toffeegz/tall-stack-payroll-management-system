<?php

namespace App\Repositories\PhicContributionRate;

use App\Models\PhicContributionRate;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class PhicContributionRateRepository extends BaseRepository implements PhicContributionRateRepositoryInterface
{

    /**
     * PhicContributionRateRepository constructor.
     *
     * @param PhicContributionRate $model
     */

    public function __construct(PhicContributionRate $model)
    {
        parent::__construct($model);
    }
}
