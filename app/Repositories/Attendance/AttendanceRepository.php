<?php

namespace App\Repositories\Attendance;

use App\Models\Attendance;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Auth;

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

    public function today()
    {
        $today = Carbon::today();
        return $this->model->whereDate('date', $today)->first();
    }

    public function index(string $search = '', string $project = null, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC')
    {
        return $this->model->where('user_id', Auth::user()->id)
        ->where(function ($query) use ($project) {
            if($project == "n/a") {
                return $query->where('project_id', null);
            } elseif($project != "" && $project != null) {
                return $query->where('project_id', $project);
            }
        })
        ->filter($search)->orderBy($sortByColumn, $sortBy)
        ->paginate($paginate);
    }

    public function getPendingForModal(string $search = '', array $relations, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC')
    {
        $search = ['search' => $search];
        return $this->model
        ->filterPending($search)
        ->select('attendances.id', 'users.last_name', 'users.first_name', 'users.code', 'attendances.date', 'users.profile_photo_path')
        ->where('attendances.status', 4)
        ->orderBy('attendances.' . $sortByColumn, $sortBy)
        ->get()->take($paginate);
        
    }
}
