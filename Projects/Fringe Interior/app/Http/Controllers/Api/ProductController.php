<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\StoreRequest;
use App\Http\Requests\Api\Product\UpdateRequest;
use App\Repositories\Cache\CacheRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Utils\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    private CacheRepositoryInterface $cacheRepository;
    private const CACHE_TAG = "products";

    public function __construct(ProductRepositoryInterface $productRepository, CacheRepositoryInterface $cacheRepository)
    {
        $this->productRepository = $productRepository;
        $this->cacheRepository = $cacheRepository;
    }

    public function index(Request $request)
    {
        $page = $request->get("page");

        $products = $this->cacheRepository->getOrSet(self::CACHE_TAG, "all_products_page_$page", function () {
            return $this->productRepository->all();
        }, 120);

        if ($products->isEmpty())
            throw new NotFoundHttpException();

        return Response::success($products, "All Products", HttpResponse::HTTP_OK);
    }

    public function store(StoreRequest $request)
    {
        $this->cacheRepository->forgetByTag(self::CACHE_TAG);
        $product = $this->productRepository->create($request->validationData());

        return Response::success($product, "Product Created", HttpResponse::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $product = $this->cacheRepository->getOrSet(self::CACHE_TAG, "product_show_$id", function () use ($id) {
            return $this->productRepository->findById($id);
        }, 120);

        return Response::success($product, "Product Show", HttpResponse::HTTP_OK);
    }

    public function update(string $id, UpdateRequest $request)
    {
        $this->cacheRepository->forgetByTag(self::CACHE_TAG);
        $updated = $this->productRepository->update($id, $request->validationData());

        return Response::success($updated, "Product Update", HttpResponse::HTTP_ACCEPTED);
    }

    public function delete(string $id)
    {

        $this->cacheRepository->forgetByTag(self::CACHE_TAG);
        $deleted = $this->productRepository->deleteById($id);
        return Response::success($deleted, "Product Delete", HttpResponse::HTTP_ACCEPTED);
    }

}
