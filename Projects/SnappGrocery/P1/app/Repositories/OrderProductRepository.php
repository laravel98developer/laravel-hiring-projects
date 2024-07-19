<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderProductRepositoryInterface;
use App\DTOs\OrderProductStoreDto;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Collection;

class OrderProductRepository implements OrderProductRepositoryInterface
{
    public function __construct(protected OrderProduct $model)
    {
    }

    /**
     * @return Collection<OrderProduct>
     */
    public function all(): Collection
    {
        return $this->model
            ->newQuery()
            ->get();
    }

    public function store(OrderProductStoreDto $orderProductStoreDto): OrderProduct
    {
        return $this->model
            ->newQuery()
            ->create([
                'order_id' => $orderProductStoreDto->getOrderId(),
                'product_id' => $orderProductStoreDto->getProductId(),
                'quantity' => $orderProductStoreDto->getQuantity(),
                'price' => $orderProductStoreDto->getPrice(),
            ]);
    }
}