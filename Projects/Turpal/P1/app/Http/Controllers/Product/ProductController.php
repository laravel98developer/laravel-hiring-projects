<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Resources\Product\ProductResource;
use App\Repositories\ProductRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepo;

    /**
     * ProductController constructor.
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->productRepo = $repository;
    }

    /**
     * search in products
     * @param ProductRequest $request
     * @return AnonymousResourceCollection
     */
    public function search(ProductRequest $request): AnonymousResourceCollection
    {
        $filters = $request->only('start_date', 'end_date');
        $products = $this->productRepo->getProducts($filters);

        return ProductResource::collection($products);
    }
}
