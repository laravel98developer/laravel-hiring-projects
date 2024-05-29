<?php

namespace AliSalehi\Task\Repositories;

use AliSalehi\Task\Models\Task;

interface TaskRepositoryInterface
{
    public function all();
    
    public function find(Task $task);
    
    public function update(Task $task, array $newDetails);
    
    public function create(array $task);
    
    public function delete(Task $task);
    
    public function getTasksByCompletionStatus();
    
    public function getTasksByInCompletionStatus();
}
