<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;
use App\Enums\OrderStatus;

class OrderStoreDto implements DtoInterface
{
    public function __construct(
        protected int         $userId,
        protected OrderStatus $status,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->getUserId(),
            'status' => $this->getStatus(),
        ];
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }
}