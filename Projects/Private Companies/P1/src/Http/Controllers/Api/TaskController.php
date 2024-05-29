<?php

namespace AliSalehi\Task\Http\Controllers\Api;

use Illuminate\Http\Request;
use AliSalehi\Task\Models\Task;
use Illuminate\Http\JsonResponse;
use AliSalehi\Task\Services\TaskService;
use AliSalehi\Task\Http\Controllers\Api\Requests\StoreRequest;

class TaskController extends ApiController
{
    public function __construct(private readonly TaskService $taskService)
    {
    }
    
    public function index(Request $request): JsonResponse
    {
        return $this->taskService->index($request);
    }
    
    public function show(Task $task): JsonResponse
    {
        return $this->taskService->show($task);
    }
    
    public function store(StoreRequest $request): JsonResponse
    {
        return $this->taskService->store($request);
    }
    
    public function update(Task $task, StoreRequest $request): JsonResponse
    {
        return $this->taskService->update($task, $request);
    }
    
    public function destroy(Task $task): JsonResponse
    {
        return $this->taskService->destroy($task);
    }
}
