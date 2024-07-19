<?php

namespace App\Contracts\Repositories;

use App\DTOs\OrderStoreDto;
use App\Models\Order;

interface OrderRepositoryInterface
{
    public function store(OrderStoreDto $orderStoreDto): Order;
}