<?php

namespace App\Repositories\Attendance;

use App\Repositories\Base\BaseRepositoryInterface;

interface AttendanceRepositoryInterface extends BaseRepositoryInterface
{
    public function today();
    public function index(string $search = '', string $project = null, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC');
    public function getPendingForModal(string $search, array $relations, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC');
    public function create(array $data);
}
