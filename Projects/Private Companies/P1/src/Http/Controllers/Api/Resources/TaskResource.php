<?php

namespace AliSalehi\Task\Http\Controllers\Api\Resources;

use AliSalehi\Task\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            Task::TITLE        => $this->{Task::TITLE},
            Task::DUE_DATE     => $this->{Task::DUE_DATE},
            Task::IS_COMPLETED => $this->{Task::IS_COMPLETED},
        ];
        
        $this->addIsHighlighted($data, $request);
        return $data;
    }
    
    private function addIsHighlighted(&$data, $request): void
    {
        if ($this->isIndexRequest($request)) {
            $data[Task::IS_HIGHLIGHTED] = $this->isHighlighted();
        }
    }
    
    private function isIndexRequest($request): bool
    {
        return $request->route()->getName() === 'task.index';
    }
    
    private function isHighlighted(): bool
    {
        $today = Carbon::today();
        $dueDate = Carbon::parse($this->{Task::DUE_DATE});
        
        return ($this->{Task::IS_COMPLETED} == false && $dueDate->isPast()) ||
            ($this->{Task::IS_COMPLETED} == false && $dueDate->diffInDays($today) <= 1);
    }
    
    public static function toPaginator($tasks, $request)
    {
        $transformedTasks = $tasks->map(function ($task) use ($request) {
            return self::make($task)->toArray($request);
        });
        return new LengthAwarePaginator(
            $transformedTasks,
            $tasks->total(),
            $tasks->perPage(),
            $tasks->currentPage(),
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );
    }
}
