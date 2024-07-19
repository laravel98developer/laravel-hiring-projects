<?php

namespace App\DTOs;

use App\Contracts\DtoInterface;

class ProductShowDto implements DtoInterface
{
    public function __construct(
        protected int    $id,
        protected string $name,
        protected string $description,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
        ];
    }

    public function getId(): int
    {
        return $this->id;
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