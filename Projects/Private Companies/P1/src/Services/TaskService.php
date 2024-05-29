<?php

namespace AliSalehi\Task\Services;

use Illuminate\Http\Request;
use AliSalehi\Task\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use AliSalehi\Task\Trait\ApiResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use AliSalehi\Task\Repositories\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use AliSalehi\Task\Http\Controllers\Api\Requests\StoreRequest;
use AliSalehi\Task\Http\Controllers\Api\Resources\TaskResource;
use AliSalehi\Task\Http\Controllers\Api\Resources\TaskCollection;

class TaskService
{
    use ApiResponseTrait;
    
    public function __construct(private readonly TaskRepositoryInterface $taskRepository)
    {
    }
    
    public function index(Request $request): JsonResponse
    {
        $tasks = $this->getFilteredTasks($request);
        //can use `TaskResource::toPaginator($tasks, $request);` to get pagination laravel format
        $paginator = TaskCollection::make($tasks);
        return $this->successResponse($paginator);
    }
    
    public function show(Task $task): JsonResponse
    {
        if ($this->checkAccess($task)) {
            try {
                $data = TaskResource::make($this->taskRepository->find($task));
                return $this->successResponse($data);
            } catch (ModelNotFoundException $e) {
                return $this->errorResponse([], trans('TASK::task.success.store'), Response::HTTP_NOT_FOUND);
            }
        }
        return $this->errorResponse([], trans('TASK::task.error.access_denied'), Response::HTTP_FORBIDDEN);
    }
    
    public function store(StoreRequest $request): JsonResponse
    {
        $this->taskRepository->create($request->all());
        return $this->successResponse([], config('TASK::task.success.store'));
    }
    
    public function update(Task $task, StoreRequest $request): JsonResponse
    {
        if ($this->checkAccess($task)) {
            try {
                $this->taskRepository->update($task, $request->all());
                return $this->successResponse([], config('TASK::task.success.update'));
            } catch (ModelNotFoundException $e) {
                return $this->errorResponse([], config('TASK::task.success.update'), Response::HTTP_NOT_FOUND);
            }
        }
        return $this->errorResponse([], config('TASK::task.error.access_denied'), Response::HTTP_FORBIDDEN);
    }
    
    public function destroy(Task $task): JsonResponse
    {
        if ($this->checkAccess($task)) {
            
            try {
                $this->taskRepository->delete($task);
                return $this->successResponse([], config('TASK::task.success.delete'));
            } catch (ModelNotFoundException $e) {
                return $this->errorResponse([], config('TASK::task.error.delete'), Response::HTTP_NOT_FOUND);
            }
        }
        return $this->errorResponse([], config('TASK::task.error.access_denied'), Response::HTTP_FORBIDDEN);
    }
    
    private function getFilteredTasks(Request $request)
    {
        $status = $request->get('status');
        
        if ($status == 'completed') {
            return $this->taskRepository->getTasksByCompletionStatus();
        } elseif ($status == 'incomplete') {
            return $this->taskRepository->getTasksByInCompletionStatus();
        }
        
        return $this->taskRepository->all();
    }
    
    private function checkAccess(Task $task): bool
    {
        return Auth::user()->getKey() === $task->{Task::USER_ID};
    }
}