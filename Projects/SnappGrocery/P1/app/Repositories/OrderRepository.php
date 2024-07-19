<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\DTOs\OrderStoreDto;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(protected Order $model)
    {
    }

    public function store(OrderStoreDto $orderStoreDto): Order
    {
        return $this->model
            ->newQuery()
            ->create([
                'user_id' => $orderStoreDto->getUserId(),
                'status' => $orderStoreDto->getStatus(),
            ]);
    }
}