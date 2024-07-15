<?php

namespace App\Services;

use App\Repositories\Cache\CacheRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Utils\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class OrderService
{
    private ProductRepositoryInterface $productRepository;
    private OrderRepositoryInterface $orderRepository;

    private CacheRepositoryInterface $cacheRepository;

    const PRODUCTS_CACHE_TAG = "products";
    const ORDERS_CACHE_TAG = "orders";

    public function __construct(ProductRepositoryInterface $productRepository, OrderRepositoryInterface $orderRepository, CacheRepositoryInterface $cacheRepository)
    {
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->cacheRepository = $cacheRepository;
    }

    public function storeOrder(array $validatedData): object
    {
        $order = $this->orderRepository->create([]);

        $orderTotalPrice = 0;
        $orderCount = 0;

        foreach ($validatedData["products"] as $item) {
            $product = $this->productRepository->findById($item["id"]);

            if ($product->inventory < $item["quantity"]) {
                return Response::error("product: {$product->name}'s inventory is less than requested quantity", HttpResponse::HTTP_BAD_REQUEST);
            }

            $orderTotalPrice += $product->price * $item["quantity"];

            $product->inventory -= $item["quantity"];

            $orderCount += $item["quantity"];

            $product->save();

            $product->quantity = (int)$item["quantity"];

            $product->inventory = null;

            $order->products()->associate($product)->save();
        }

        $order->total_price = $orderTotalPrice;
        $order->count = $orderCount;

        $order->save();

        $this->cacheRepository->forgetByTag(self::ORDERS_CACHE_TAG);
        $this->cacheRepository->forgetByTag(self::PRODUCTS_CACHE_TAG);

        return Response::success($order, "Order Created", HttpResponse::HTTP_CREATED);
    }

    public function updateOrder(string $id, array $validatedData): object
    {
        $order = $this->orderRepository->findById($id);

        $orderTotalPrice = 0;
        $orderCount = 0;

        foreach ($validatedData["products"] as $item) {
            $product = $this->productRepository->findById($item["id"]);

            $orderTotalPrice += $product->price * $item["quantity"];

            $orderProduct = $order->products()->find($product->id);

            $diffQuantity = $item["quantity"] - (int)$orderProduct->quantity;

            if ($diffQuantity > 0) {

                if ($product->inventory < $diffQuantity) {
                    return Response::error("product: {$product->name}'s inventory is less than requested quantity", HttpResponse::HTTP_BAD_REQUEST);
                }

                $product->inventory -= $diffQuantity;
                $orderCount += $diffQuantity;

                $product->save();

            } elseif ($diffQuantity < 0) {
                $product->inventory += abs($diffQuantity);
                $orderCount -= $diffQuantity;
                $product->save();
            }

            $product->quantity = (int)$item["quantity"];

            $product->inventory = null;

            $order->products()->associate($product)->save();
        }
        $order->total_price = $orderTotalPrice;
        $order->count = $orderCount;
        $order->save();

        $this->cacheRepository->forgetByTag(self::ORDERS_CACHE_TAG);
        $this->cacheRepository->forgetByTag(self::PRODUCTS_CACHE_TAG);

        return Response::success($order, "Order Update", HttpResponse::HTTP_ACCEPTED);
    }

    public function deleteOrder(string $id)
    {
        $order = $this->orderRepository->findById($id);

        foreach ($order->products as $orderProduct){
            $product = $this->productRepository->findById($orderProduct->id);
            $product->inventory += $orderProduct->quantity;
            $product->save();
        }

        $this->cacheRepository->forgetByTag(self::ORDERS_CACHE_TAG);
        $this->cacheRepository->forgetByTag(self::PRODUCTS_CACHE_TAG);

        $deleted = $order->delete();

        return Response::success($deleted, "Order Delete", HttpResponse::HTTP_ACCEPTED);
    }
}
