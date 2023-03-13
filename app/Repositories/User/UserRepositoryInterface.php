<?php

namespace App\Repositories\User;

use App\Repositories\Base\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getUserByEmail(string $email);
    public function getUsersByAuthUserRole(string $search, array $relations, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC');
}
