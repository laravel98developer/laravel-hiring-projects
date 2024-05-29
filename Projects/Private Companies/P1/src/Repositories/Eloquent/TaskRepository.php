<?php

namespace AliSalehi\Task\Repositories\Eloquent;

use AliSalehi\Task\Models\Task;
use AliSalehi\Task\Repositories\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        return Task::query()->paginate(5);
    }
    
    public function find(Task $task)
    {
        return Task::query()->findOrFail($task->getKey());
    }
    
    public function create(array $task)
    {
        return Task::query()->create($task);
    }
    
    public function update(Task $task, array $newDetails)
    {
        return Task::query()->whereId($task->getKey())->update($newDetails);
    }
    
    public function delete(Task $task)
    {
        return Task::query()->where(Task::Id, $task->getKey())->delete();
    }
    
    public function getTasksByCompletionStatus()
    {
        return Task::query()->where(Task::IS_COMPLETED, Task::$IS_COMPLETED['true'])->paginate(5);
    }
    
    public function getTasksByInCompletionStatus()
    {
        return Task::query()->where(Task::IS_COMPLETED, Task::$IS_COMPLETED['false'])->paginate(5);
    }
}
