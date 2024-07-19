<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;
use Illuminate\Support\Collection;

class OrderWithOrderProductStoreDto implements DtoInterface
{
    /**
     * @param int $userId
     * @param Collection<OrderProductWithoutOrderIdStoreDto> $orderProductWithoutOrderIdDtos
     */
    public function __construct(
        protected int        $userId,
        protected Collection $orderProductWithoutOrderIdDtos,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->getUserId(),
            'order_product_without_order_id_dtos' => $this->getOrderProductWithoutOrderIdDtos(),
        ];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getOrderProductWithoutOrderIdDtos(): Collection
    {
        return $this->orderProductWithoutOrderIdDtos;
    }
}