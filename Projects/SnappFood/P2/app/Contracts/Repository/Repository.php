<?php

namespace App\Contracts\Repository;

interface Repository
{
    public function find(string $id, ?array $with = []);

    public function exist(string $id): bool;

    public function all(?array $with = [], ?array $filters = [], ?array $select = []);

    public function update(array $data, string $id);

    public function create(array $data);

    public function delete(string $id);
}
