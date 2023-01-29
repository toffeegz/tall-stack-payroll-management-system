<?php

namespace App\Services\Project;

use App\Repositories\Project\ProjectRepositoryInterface;
use App\Services\Project\ProjectServiceInterface;
use App\Models\Project;
use Carbon\Carbon;

class ProjectService implements ProjectServiceInterface
{
    private ProjectRepositoryInterface $modelRepository;

    public function __construct(
        ProjectRepositoryInterface $modelRepository,
    ) {
        $this->modelRepository = $modelRepository;
    }

    public function generateCode()
    {
        $latest_project = Project::orderBy('code', 'desc')->whereYear('created_at', Carbon::now('Y'))->first();
        if($latest_project) {
            $latest_code = $latest_project->code;
            $last_digits = substr($latest_code, 6) + 1;
        } else {
            $last_digits = 1;
        }
        
        $code = Carbon::now()->format('Y') . "-" . sprintf('%04d', $last_digits);
        $code = '2022' . "-" . sprintf('%04d', $last_digits);
        return $code;
    }
    
}