<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAll($productData)
    {
        return $this->productRepository->getAll($productData);
    }

    public function addProduct($productData)
    {
        return $this->productRepository->create($productData);
    }

    public function getProduct($productId)
    {
        return $this->productRepository->getById($productId);
    }

    public function updateProduct($productId, $productData)
    {
        return $this->productRepository->update($productId, $productData);
    }

    public function deleteProduct($productId)
    {
        return $this->productRepository->delete($productId);
    }

}
