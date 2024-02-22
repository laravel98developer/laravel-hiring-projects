<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

interface BaseRepositoryInterface
{
    public function query(array $payload = []);

    public function paginate($limit = 15, array $payload = []);

    public function all(array $payload = []);

    public function create(array $payload);

    public function update($eloquent, array $payload);

    public function updateOrCreate(array $condition, array $payload);

    public function delete($eloquent): bool;

    public function forceDelete($eloquent): bool;

    /**
     * @param mixed  $value
     * @param string $filed
     * @param array  $selected
     * @param bool   $firstOrFail
     * @param array  $with
     * @param bool   $withTrashed
     */
    public function find(mixed $value, string $filed = 'id', array $selected = ['*'], bool $firstOrFail = false, array $with = [], bool $withTrashed = false);

    public function getModel(): Model;

    public function toggle($model, string $field = "published");
}
