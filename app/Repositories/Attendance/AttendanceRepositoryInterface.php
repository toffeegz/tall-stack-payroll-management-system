<?php

namespace App\Repositories\Attendance;

use App\Repositories\Base\BaseRepositoryInterface;

interface AttendanceRepositoryInterface extends BaseRepositoryInterface
{
    public function getPendingForModal(string $search, array $relations, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC');
}
