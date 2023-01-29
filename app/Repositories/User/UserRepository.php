<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Carbon;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUserByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getUsersByAuthUserRole(string $search, array $relations, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC')
    {
        $search = ['search' => $search];
        if($relations) {
            $this->model = $this->model->with($relations);
        }
        if(Auth::user()->hasRole('administrator')) {
            return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate($paginate);
        } elseif(Auth::user()->hasRole('timekeeper')) {
            return Auth::user()->project()->users()->filter($search)->orderBy($sortByColumn, $sortBy)->paginate($paginate);
        }
    }
}
