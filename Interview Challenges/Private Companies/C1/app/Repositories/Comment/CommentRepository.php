<?php

namespace App\Repositories\Comment;

use App\Models\Comment;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function getModel(): Comment
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
