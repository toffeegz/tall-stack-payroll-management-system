<?php

namespace App\Repositories\Project;

use App\Models\Project;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

    /**
     * ProjectRepository constructor.
     *
     * @param Project $model
     */

    public function __construct(Project $model)
    {
        parent::__construct($model);
    }
}
