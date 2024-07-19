<?php

namespace App\Helpers;

use App\DTOs\OrderProductStoreDto;
use App\DTOs\OrderProductWithoutOrderIdStoreDto;
use App\DTOs\OrderStoreDto;
use App\DTOs\OrderWithOrderProductShowDto;
use App\DTOs\OrderWithOrderProductStoreDto;
use App\DTOs\ProductShowDto;
use App\DTOs\ProductStoreDto;
use App\Enums\OrderStatus;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;

class DtoHelper
{
    public static function productToProductShowDto(Product $product): ProductShowDto
    {
        return new ProductShowDto(id: $product->id, name: $product->name, description: $product->description);
    }

    public static function orderAndOrderProductDtosToOrderShowDto(Order $order, Collection $orderProductShowDtos): OrderWithOrderProductShowDto
    {
        return new OrderWithOrderProductShowDto(
            id: $order->id,
            userId: $order->user_id,
            status: $order->status,
            orderProductShowDtos: $orderProductShowDtos,
        );
    }

    public static function requestToProductStoreDto(ProductStoreRequest $request): ProductStoreDto
    {
        return new ProductStoreDto(name: $request->input('name'), description: $request->input('description'));
    }

    public static function dataToOrderStoreDto(int $userId, OrderStatus $status): OrderStoreDto
    {
        return new OrderStoreDto(userId: $userId, status: $status);
    }

    public static function orderProductWithoutOrderIdStoreDtoToOrderProductStoreDto(
        OrderProductWithoutOrderIdStoreDto $orderProductWithoutOrderIdStoreDto,
        int                                $orderId,
    ): OrderProductStoreDto
    {
        return new OrderProductStoreDto(
            orderId: $orderId,
            productId: $orderProductWithoutOrderIdStoreDto->getProductId(),
            price: $orderProductWithoutOrderIdStoreDto->getPrice(),
            quantity: $orderProductWithoutOrderIdStoreDto->getQuantity(),
        );
    }

    public static function requestTOrderStoreDto(OrderStoreRequest $request): OrderWithOrderProductStoreDto
    {
        $orderProductWithoutOrderIdDtos = [];
        foreach ($request->input('products') as $product) {
            $orderProductWithoutOrderIdDtos[] = self::dataToOrderProductWithoutOrderIdDto(productId: $product['product_id'], price: $product['price'], quantity: $product['quantity']);
        }
        return new OrderWithOrderProductStoreDto(
            userId: 1,
            orderProductWithoutOrderIdDtos: collect($orderProductWithoutOrderIdDtos)
        );
    }

    public static function dataToOrderProductWithoutOrderIdDto(
        int $productId,
        int $price,
        int $quantity,
    ): OrderProductWithoutOrderIdStoreDto
    {
        return new OrderProductWithoutOrderIdStoreDto(
            productId: $productId,
            price: $price,
            quantity: $quantity,
        );
    }
}