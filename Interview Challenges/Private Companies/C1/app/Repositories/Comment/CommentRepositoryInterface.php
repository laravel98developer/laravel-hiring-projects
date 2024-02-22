<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepositoryInterface;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function getModel(): Comment;
}
