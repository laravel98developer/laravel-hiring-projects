<?php

namespace App\Services;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Contracts\Services\ProductServiceInterface;
use App\DTOs\ProductShowDto;
use App\DTOs\ProductStoreDto;
use App\Helpers\DtoHelper;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductService implements ProductServiceInterface
{
    public function __construct(protected ProductRepositoryInterface $repository)
    {
    }

    /**
     * @return Collection<ProductShowDto>
     */
    public function all(): Collection
    {
        return $this->repository->all()->map(fn(Product $product) => DtoHelper::productToProductShowDto($product));
    }

    public function store(ProductStoreDto $dto): ProductShowDto
    {
        $product = $this->repository->store($dto);
        return DtoHelper::productToProductShowDto($product);
    }
}