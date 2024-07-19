<?php

namespace App\Repositories\Db;

use App\Contracts\Repository\Repository;
use App\Exceptions\Repository\Invalid;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

abstract class BaseRepository implements Repository
{
    protected Application $app;

    protected Model $model;

    protected ?string $defaultOrderByDesc = 'id';

    protected ?string $defaultOrderByAsc = null;

    protected ?string $defaultPrimaryKeyName = 'id';

    public function __construct()
    {
        $this->makeModel();
    }

    public function all(?array $with = [], $filters = [], $select = []): LengthAwarePaginator
    {
        $list = $this->model::query()
            ->when(! empty($this->defaultOrderByDesc), function ($query) {
                $query->orderByDesc($this->defaultOrderByDesc);
            })
            ->when(! empty($this->defaultOrderByAsc), function ($query) {
                $query->orderBy($this->defaultOrderByAsc);
            });

        if (! empty($select)) {
            $list = $list->select($select);
        }

        if (! empty($filters)) {
            foreach ($filters as $key => $value) {
                $list = $list->where($key, $value);
            }
        }

        return $list->with($with)->paginate();
    }

    public function find(string $id, ?array $with = []): Model|Collection|Builder|array|null
    {
        return $this->model::query()->find($id);
    }

    public function exist(string $id): bool
    {
        return $this->model::query()
            ->where($this->defaultOrderByDesc, $id)
            ->exists();
    }

    public function update(array $data, $id): Model|Collection|Builder|array|null
    {
        $record = $this->find($id);
        $record->update($data);
        $this->clearCache();

        return $record;
    }

    public function create(array $data): Model|Builder
    {
        $entity = $this->model->query()->create($data);
        $this->clearCache();

        return $entity;
    }

    public function delete(string $id): Model|Collection|Builder|array|null
    {
        $entity = $this->find($id);
        $entity->delete();
        $this->clearCache();

        return $entity;
    }

    protected function makeModel(): void
    {
        $model = app($this->model());
        if (! $model instanceof Model) {
            throw new Invalid(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }

        $this->model = $model;
    }

    protected function clearCache(): void
    {
        if (property_exists($this->model, 'cacheTags')) {
            Cache::tags($this->model->cacheTags)->flush();
        }
    }

    abstract protected function model(): string;
}
