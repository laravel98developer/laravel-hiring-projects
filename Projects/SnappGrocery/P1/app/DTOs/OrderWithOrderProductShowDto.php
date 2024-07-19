<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;
use App\Enums\OrderStatus;
use Illuminate\Support\Collection;

class OrderWithOrderProductShowDto implements DtoInterface
{
    /**
     * @param int $id
     * @param int $userId
     * @param OrderStatus $status
     * @param Collection<OrderProductShowDto>|null $orderProductShowDtos
     */
    public function __construct(
        protected int         $id,
        protected int         $userId,
        protected OrderStatus $status,
        protected Collection  $orderProductShowDtos,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'status' => $this->getStatus(),
            'order_product_Store_dtos' => $this->getOrderProductShowDtos(),
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return Collection
     */
    public function getOrderProductShowDtos(): Collection
    {
        return $this->orderProductShowDtos;
    }
}