<?php

namespace App\services\OrderService\Services;

use App\services\OrderService\Contracts\OrderRepositoryInterface;

class OrderService
{
    public function __construct(public OrderRepositoryInterface $orderRepository)
    {
    }

    public function filters(array $data)
    {
        return $this->orderRepository->filterBy($data);
    }
}
