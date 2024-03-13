<?php


namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ProductRepository
{
    /**
     * get product list
     * @param array $filters
     * @return Builder[]|Collection
     */
    public function getProducts(array $filters): Collection|array
    {
        return $this->makeProductQuery($filters)->get();
    }

    /**
     * make product query
     * @param array $filters
     * @return Builder
     */
    public function makeProductQuery(array $filters): Builder
    {
        return Product::query()
            ->whereHas('availability', function (Builder $builder) use ($filters) {
                $builder->where([
                    ['start_date', '>=', Arr::get($filters, 'start_date')],
                    ['end_date', '<=', Arr::get($filters, 'end_date')]
                ]);
            });
    }

    /**
     * @param $data
     * @return Builder|Model
     */
    public function create($data): Model|Builder
    {
        return Product::query()->create($data);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateWithId($id, $data): mixed
    {
        return Product::query()
            ->where('id', $id)
            ->update($data);
    }


}
