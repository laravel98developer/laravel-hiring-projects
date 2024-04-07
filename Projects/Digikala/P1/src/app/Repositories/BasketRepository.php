<?php

namespace App\Repositories;

use App\Models\Basket;

class BasketRepository
{
    private $model;

    public function __construct(Basket $basket)
    {
        $this->model = $basket;
    }

    public function getAll($showDataOptions)
    {
        $baskets = $this->model->query();
        if (isset($showDataOptions['user_id'])) {
            $baskets->where('user_id',$showDataOptions['user_id']);
        }
        $sort_column = $showDataOptions['sort_column'] ?? 'created_at';
        $baskets->orderBy($sort_column, isset($showDataOptions['is_sort_dir_desc']) && $showDataOptions['is_sort_dir_desc']=='true' ? 'desc' : 'asc');

        return $baskets->paginate($showDataOptions['per_page'] ?? 10);
    }

    public function create($basketData)
    {
        return $this->model->create($basketData);
    }

    public function getById($basketId)
    {
        return $this->model->findOrFail($basketId);
    }

    public function update($basketId, $basketData)
    {
        $basket = $this->getById($basketId);
        return $basket->update($basketData);
    }

    public function delete($basketId)
    {
        $basket = $this->getById($basketId);
        return $basket->delete();
    }

    public function getUserBasketByProductId($productId): bool
    {
        $basketCount = $this->model->where('user_id', auth()->user()->id)
            ->where('product_id', $productId)->count();
        return $basketCount ? true : false;
    }


}
