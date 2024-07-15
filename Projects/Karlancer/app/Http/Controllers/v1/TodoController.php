<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseJson;
use App\Http\Requests\v1\Todo\IndexRequest;
use App\Http\Requests\v1\Todo\StoreRequest;
use App\Http\Requests\v1\Todo\UpdateRequest;
use App\Http\Resources\v1\Todo\ListResource;
use App\Http\Resources\v1\Todo\ShowResource;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TodoController extends Controller
{
    public function index(IndexRequest $request): JsonResponse
    {
        $todos = Todo::query()->select([
            "todos.id",
            "todos.description",
            "todos.done",
            "todos.due_date",
            "todos.created_at",
            "todos.updated_at",
            "categories.id as category_id",
            "categories.name as category_name"
        ])->leftJoin("categories", "categories.id", "=", "todos.category_id")
            ->where("todos.user_id", "=", Auth::id())
            ->when($request->get("done") != null, fn($q) => $q->where("todos.done", "=", $request->get("done")))
            ->when($request->get("category_id") != null, fn($q) => $q->where("categories.id", "=", $request->get("category_id")))
            ->orderBy("updated_at", "desc")
            ->paginate(50);

        if ($todos->isEmpty()) {
            throw new NotFoundHttpException();
        }

        return ResponseJson::success(ListResource::collection($todos)->resource, "user's todo list", Response::HTTP_OK);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $todo = Auth::user()->todos()->create($payload);

        return ResponseJson::success(ShowResource::make($todo), "todo created", Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        $todo = Todo::query()->findOrFail($id);

        Gate::authorize("todo-view", $todo);

        return ResponseJson::success($todo, "show todo", Response::HTTP_OK);
    }

    public function update(int $id, UpdateRequest $request): JsonResponse
    {
        $todo = Todo::query()->findOrFail($id);

        Gate::authorize("todo-update", $todo);

        $payload = $request->validated();

        $updated = $todo->update($payload);

        return ResponseJson::success(["updated" => $updated], "update todo", Response::HTTP_ACCEPTED);
    }

    public function destroy(int $id): JsonResponse
    {
        $todo = Todo::query()->findOrFail($id);

        Gate::authorize("todo-delete", $todo);

        $deleted = $todo->delete();

        return ResponseJson::success(["deleted" => $deleted], "delete todo", Response::HTTP_ACCEPTED);
    }
}
