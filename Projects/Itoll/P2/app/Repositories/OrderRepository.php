<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Dtos\OrderStoreDto;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(protected Order $model)
    {
    }

    public function store(OrderStoreDto $orderStoreDto): Order
    {
        return $this->model
            ->newQuery()
            ->create($orderStoreDto->toArray());
    }

    public function getBySupplierId(int $supplierId): Collection
    {
        return $this->model
            ->newQuery()
            ->where('supplier_id', $supplierId)
            ->get();
    }

    public function findByIdOrFail(int $orderId): Order
    {
        return $this->model
            ->newQuery()
            ->findOrFail($orderId);
    }

    public function deleteById(int $orderId): void
    {
        $this->model
            ->newQuery()
            ->findOrFail($orderId)
            ->delete();
    }

    public function getByStatus(OrderStatusEnum $status): Collection
    {
        return $this->model
            ->newQuery()
            ->where('status', $status)
            ->get();
    }

    public function accept(int $orderId, int $deliveryId): void
    {
        $this->model
            ->newQuery()
            ->where('id', $orderId)
            ->findOrFail($orderId)
            ->update([
                'status' => OrderStatusEnum::ACCEPTED,
                'delivery_id' => $deliveryId
            ]);
    }

    public function updateStatus(int $orderId, OrderStatusEnum $status): void
    {
        $this->model
            ->newQuery()
            ->where('id', $orderId)
            ->findOrFail($orderId)
            ->update([
                'status' => $status,
            ]);
    }
}
