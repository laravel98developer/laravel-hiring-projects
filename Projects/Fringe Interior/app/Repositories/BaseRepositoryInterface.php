<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{

    public function findById(string $modelId, array $columns = ["*"], array $relations = []);

    public function create(array $payload);

    public function update(string $modelId, array $payload);

    public function deleteById(string $modelId);

}
