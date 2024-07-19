<?php

namespace App\Contracts\Repositories;

use App\Dtos\OrderStoreDto;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface
{
    public function store(OrderStoreDto $orderStoreDto): Order;

    public function getBySupplierId(int $supplierId): Collection;

    public function findByIdOrFail(int $orderId): Order;

    public function deleteById(int $orderId): void;

    public function getByStatus(OrderStatusEnum $status): Collection;

    public function accept(int $orderId, int $deliveryId): void;

    public function updateStatus(int $orderId, OrderStatusEnum $status): void;
}
