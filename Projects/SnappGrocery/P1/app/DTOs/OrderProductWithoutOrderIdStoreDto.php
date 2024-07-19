<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;

class OrderProductWithoutOrderIdStoreDto implements DtoInterface
{
    public function __construct(
        protected int $productId,
        protected int $price,
        protected int $quantity,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'product_id' => $this->getProductId(),
            'price' => $this->getPrice(),
            'quantity' => $this->getQuantity(),
        ];
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