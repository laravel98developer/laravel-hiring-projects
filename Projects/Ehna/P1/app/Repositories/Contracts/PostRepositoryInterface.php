<?php

namespace App\Repositories\Contracts;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function index(int $perPage);

    public function create(array $data);

    public function update(Post $post, array $data);

    public function find(int $id);

    public function delete(Post $post);
}
