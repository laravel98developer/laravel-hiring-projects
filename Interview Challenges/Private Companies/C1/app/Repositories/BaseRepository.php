<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

class BaseRepository implements BaseRepositoryInterface
{

    public function __construct(public Model $model)
    {
    }

    public function query(array $payload = [])
    {
        return $this->model->query();
    }

    public function paginate($limit = null, array $payload = [])
    {
        return $this->query($payload)->paginate($limit);
    }

    public function all(array $payload = [])
    {
        return $this->query($payload)->get();
    }

    public function create(array $payload)
    {
        return $this->model->create($payload);
    }

    public function update($eloquent, array $payload)
    {
        return tap($eloquent)->update($payload);
    }

    public function updateOrCreate(array $condition, array $payload)
    {
        return $this->model->updateOrCreate($condition, $payload);
    }

    public function delete($eloquent): bool
    {
        return $eloquent->delete();
    }

    public function forceDelete($eloquent): bool
    {
        return $eloquent->forceDelete();
    }

    public function find(mixed $value, string $filed = 'id', array $selected = ['*'], bool $firstOrFail = false, array $with = [], bool $withTrashed = false)
    {
        $model = $this->getModel()
                      ->when($withTrashed, fn($q) => $q->withTrashed())
                      ->with($with)->select($selected)
                      ->when(
                          is_array($value),
                          fn($q) => $q->whereIn($filed, $value),
                          fn($q) => $q->where($filed, $value)
                      );

        if ($firstOrFail) {
            return $model->firstOrFail();
        }

        if (is_array($value)) {
            return $model->get();
        }

        return $model->first();
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function toggle($model, string $field = 'published')
    {
        $model[$field] = !$model[$field];
        $model->save();

        return $model;
    }


}
