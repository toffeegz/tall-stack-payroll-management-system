<?php

namespace App\Repositories\Base;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function items(array $search, array $relations, $paginate = 10, $sortByColumn = 'created_at', $sortBy = 'DESC')
    {
        if($relations) {
            $this->model = $this->model->with($relations);
        }

        return $this->model->filter($search)->orderBy($sortByColumn, $sortBy)->paginate($paginate);
    }

    public function show(string $id, $with = [])
    {
        return $this->model->with($with)->withTrashed()->findOrFail($id);
    }

    public function showWithoutTrashed(string $id, $with = [])
    {
        return $this->model->with($with)->findOrFail($id);
    }

    public function update(array $params, string $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->findOrFail($id);
            $result->update($params);
            DB::commit();
            return $this->model->findOrFail($id);
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
    
    public function create(array $params)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->create($params);
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function updateOrCreate(array $references, array $params)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->updateOrCreate($references, $params);
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function firstOrCreate(array $references, array $params)
    {
        DB::beginTransaction();
        try {
            $data = $this->model->firstOrCreate($references, $params);
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function secureDelete(string $id, array $relations)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->findOrFail($id);
            $hasRelation = $result->secureDelete($relations);
            if($hasRelation == false) {
                $result->delete();
            }
            DB::commit();
            return $hasRelation == true ? false : $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function restore(string $id)
    {
        DB::beginTransaction();
        try {
            $result = $this->model->onlyTrashed()->findOrFail($id);
            $result->restore();
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}