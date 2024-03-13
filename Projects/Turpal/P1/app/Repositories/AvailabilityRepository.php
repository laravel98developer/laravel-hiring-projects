<?php

namespace App\Repositories;

use App\Models\Availability;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AvailabilityRepository
{
    /**
     * @param $data
     * @return Builder|Model
     */
    public function create($data): Model|Builder
    {
        return Availability::query()->create($data);
    }

    /**
     * @param $productId
     * @param $data
     * @return mixed
     */
    public function updateWithProductId($productId, $data): mixed
    {
        return Availability::query()
            ->where('product_id', $productId)
            ->update($data);
    }


    /**
     * @param array $condition
     * @param array $data
     * @return Builder|Model
     */
    public function updateOrCreate(array $condition, array $data): Model|Builder
    {
        return Availability::query()->updateOrCreate($condition, $data);
    }
}
