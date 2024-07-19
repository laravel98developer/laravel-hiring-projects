<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\DTOs\ProductStoreDto;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(protected Product $model)
    {
    }

    /**
     * @return Collection<Product>
     */
    public function all(): Collection
    {
        return $this->model
            ->newQuery()
            ->get();
    }

    public function store(ProductStoreDto $productDto): Product
    {
        return $this->model
            ->newQuery()
            ->create([
                'name' => $productDto->getName(),
                'description' => $productDto->getDescription(),
            ]);
    }
}