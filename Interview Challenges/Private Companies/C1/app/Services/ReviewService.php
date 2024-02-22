<?php

namespace App\Services;

use App\Actions\Comment\GetProductCommentsAction;
use App\Actions\Vote\GetProductVotesAction;
use App\Http\Resources\CommentResource;
use App\Http\Resources\VoteResource;
use Illuminate\Support\Collection;

class ReviewService
{
    public function __construct(
        private GetProductCommentsAction $getProductComments,
        private GetProductVotesAction $getProductVotesAction,
    )
    {
    }

    public function getReviews(Collection $products)
    {
        $productIds = $products->pluck('id')->toArray();
        $comments = $this->getProductComments->handle($productIds);
        $products = $this->addComments($products, $comments);
        $votes = $this->getProductVotesAction->handle($productIds);
        $products = $this->addVotes($products, $votes);

        return $products;
    }

    private function addComments(Collection $products, Collection $comments): Collection
    {
        return $products->map(function ($product) use ($comments) {
            $comments = $comments->firstWhere('product_id', $product->id);
            $comments = $comments['comments'] ?? collect([]);
            $product->comments = CommentResource::collection($comments->take(3));
            $product->total_comments = $comments->count();

            return $product;
        });
    }

    private function addVotes(Collection $products, Collection $votes): Collection
    {
        return $products->map(function ($product) use ($votes) {
            $votes = $votes->firstWhere('product_id', $product->id);
            $votes = $votes['votes'] ?? collect([]);
            $product->votes = VoteResource::collection($votes);
            $product->total_votes = $votes->count();
            $product->avg_votes = $votes->avg('rate');

            return $product;
        });
    }
}
