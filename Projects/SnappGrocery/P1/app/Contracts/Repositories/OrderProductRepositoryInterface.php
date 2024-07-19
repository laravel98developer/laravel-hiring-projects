<?php

namespace App\Contracts\Repositories;

use App\DTOs\OrderProductStoreDto;
use App\Models\OrderProduct;
use Illuminate\Database\Eloquent\Collection;

interface OrderProductRepositoryInterface
{

    /**
     * @return Collection<OrderProduct>
     */
    public function all(): Collection;

    public function store(OrderProductStoreDto $orderProductStoreDto): OrderProduct;
}