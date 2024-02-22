<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getModel(): Product
    {
        return parent::getModel();
    }

    public function query(array $payload = [])
    {
        return $this->getModel()->newQuery()
            ->when($payload['status'], function (Builder $query) use ($payload) {
                $query->where('status', $payload['status']);
            });
    }
}
