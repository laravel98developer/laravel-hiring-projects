<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PostController extends Controller
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index(): JsonResponse
    {
        return response()->json($this->postRepository->index(15));
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->postRepository->create($request->validated() + [
                'user_id' => auth()->id(),
            ]);

        return response()->json([
            'data' => $post,
            'message' => 'پست جدید ایجاد شد.',
        ], Response::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        return response()->json([
            'data' => $this->postRepository->find($id),
        ]);
    }

    public function update(UpdatePostRequest $request, $id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        if (auth()->id() != $post->user_id) {
            throw new AuthorizationException('دسترسی ندارید.', Response::HTTP_FORBIDDEN);
        }

        $this->postRepository->update($post, $request->validated());

        return response()->json([
            'data' => $post,
            'message' => 'پست ویرایش شد.',
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $post = $this->postRepository->find($id);

        if (auth()->id() != $post->user_id) {
            throw new AuthorizationException('دسترسی ندارید.', Response::HTTP_FORBIDDEN);
        }

        $this->postRepository->delete($post);

        return response()->json([
            'message' => 'پست حذف شد.',
        ]);
    }
}
