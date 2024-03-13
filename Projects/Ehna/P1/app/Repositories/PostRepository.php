<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function index(int $perPage)
    {
        return Post::select(['id', 'user_id', 'title', 'description'])->paginate(15);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data)
    {
        return $post->update($data);
    }

    public function find(int $id)
    {
        return Post::findOrFail($id);
    }

    public function delete(Post $post)
    {
        return $post->delete();
    }
}
