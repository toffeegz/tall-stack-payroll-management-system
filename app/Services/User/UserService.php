<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $modelRepository;

    public function __construct(
        UserRepositoryInterface $modelRepository,
        ProjectRepositoryInterface $projectRepository,
    ) {
        $this->modelRepository = $modelRepository;
        $this->projectRepository = $projectRepository;
    }

    
}