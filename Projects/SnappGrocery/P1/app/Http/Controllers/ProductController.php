<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ProductServiceInterface;
use App\Helpers\DtoHelper;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductController extends Controller
{
    public function __construct(protected ProductServiceInterface $productService)
    {
    }

    public function index(): JsonResource
    {
        $products = $this->productService->all();
        return ProductResource::collection($products);
    }

    public function store(ProductStoreRequest $request): JsonResource
    {
        $productStoreDto = DtoHelper::requestToProductStoreDto($request);
        $productShowDto = $this->productService->store($productStoreDto);
        return ProductResource::make($productShowDto);
    }
}
