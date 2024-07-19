<?php

namespace App\Contracts\Repositories;

use App\DTOs\ProductStoreDto;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface
{

    /**
     * @return Collection<Product>
     */
    public function all(): Collection;

    public function store(ProductStoreDto $productDto): Product;
}