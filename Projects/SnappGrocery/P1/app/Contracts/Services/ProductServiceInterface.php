<?php

namespace App\Contracts\Services;

use App\DTOs\ProductShowDto;
use App\DTOs\ProductStoreDto;
use Illuminate\Support\Collection;

interface ProductServiceInterface
{

    /**
     * @return Collection<ProductShowDto>
     */
    public function all(): Collection;

    public function store(ProductStoreDto $dto): ProductShowDto;
}