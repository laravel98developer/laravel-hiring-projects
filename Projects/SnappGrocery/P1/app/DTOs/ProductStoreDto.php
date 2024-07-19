<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;

class ProductStoreDto implements DtoInterface
{
    public function __construct(
        protected string $name,
        protected string $description,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}