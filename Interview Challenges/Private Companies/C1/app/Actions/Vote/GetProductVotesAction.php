<?php

namespace App\Actions\Vote;


use App\Repositories\Vote\VoteRepositoryInterface;

class GetProductVotesAction
{
    public function __construct(
        private VoteRepositoryInterface $voteRepository,
    )
    {
    }

    public function handle(array $productIds)
    {
        $votes = $this->voteRepository->all([
            'product_ids' => $productIds,
            'confirmed'   => true,
        ]);

        return collect($votes)->groupBy('product_id')->map(function ($votes, $productId) {
            return [
                'product_id' => $productId,
                'votes'      => $votes
            ];
        });
    }
}
