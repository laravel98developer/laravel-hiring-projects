<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;

class OrderProductStoreDto implements DtoInterface
{
    public function __construct(
        protected int $orderId,
        protected int $productId,
        protected int $price,
        protected int $quantity,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'order_id' => $this->getOrderId(),
            'product_id' => $this->getProductId(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
        ];
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}