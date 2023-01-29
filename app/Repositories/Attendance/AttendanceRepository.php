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

    public function getPendingForModal(string $search, array $relations, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC')
    {
        $search = ['search' => $search];
        return $this->model->filterPending($search)
        ->select('attendances.id', 'users.last_name', 'users.first_name', 'users.code', 'attendances.date', 'users.profile_photo_path')
        ->where('attendances.status', 4)
        ->orderBy('attendances.' . $sortByColumn, $sortBy)->paginate($paginate);
    }
}
