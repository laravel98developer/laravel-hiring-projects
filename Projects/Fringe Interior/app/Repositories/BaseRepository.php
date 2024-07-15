<?php

namespace App\Repositories;

use Jenssegers\Mongodb\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{

    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ["*"], array $relations = [])
    {
        return $this->model->query()->select($columns)->with($relations)->paginate(50);
    }

    public function findById(string $modelId, array $columns = ["*"], array $relations = [])
    {
        return $this->model->query()->select($columns)->with($relations)->findOrFail($modelId);
    }

    public function create(array $payload)
    {
        return $this->model->query()->create($payload);
    }

    public function update(string $modelId, array $payload)
    {
        $model = $this->model->query()->findOrFail($modelId);
        return $model->update($payload);
    }

    public function deleteById(string $modelId)
    {
        return $this->model->query()->findOrFail($modelId)->delete();
    }

}
