<?php

namespace App\Repositories\Vote;

use App\Models\Vote;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class VoteRepository extends BaseRepository implements VoteRepositoryInterface
{
    public function __construct(Vote $model)
    {
        parent::__construct($model);
    }

    public function getModel(): Vote
    {
        return parent::getModel();
    }

    public function query(array $payload = [])
    {
        return $this->getModel()->newQuery()
                    ->when($payload['confirmed'], function (Builder $query) use ($payload) {
                        $query->where('confirmed', $payload['confirmed']);
                    })
                    ->when(!empty($payload['product_ids']), function (Builder $query) use ($payload) {
                        $query->whereIn('product_id', $payload['product_ids']);
                    });
    }
}
