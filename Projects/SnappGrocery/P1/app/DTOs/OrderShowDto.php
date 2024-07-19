<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;
use App\Enums\OrderStatus;

class OrderShowDto implements DtoInterface
{
    public function __construct(
        protected int         $id,
        protected int         $userId,
        protected OrderStatus $status,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'status' => $this->getStatus(),
        ];
    }

    public function getId(): int
    {
        return $this->id;
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