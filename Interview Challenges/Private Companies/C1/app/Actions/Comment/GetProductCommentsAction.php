<?php

namespace App\Actions\Comment;

use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Support\Collection;

class GetProductCommentsAction
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
    )
    {
    }

    public function handle(array $productIds): Collection
    {
        $comments = $this->commentRepository->all([
            'confirmed'   => true,
            'product_ids' => $productIds,
        ]);

        return collect($comments)
            ->sortByDesc('id')
            ->groupBy('product_id')
            ->map(function ($comments, $productId) {
                return [
                    'product_id' => $productId,
                    'comments'   => $comments,
                ];
            });
    }
}
