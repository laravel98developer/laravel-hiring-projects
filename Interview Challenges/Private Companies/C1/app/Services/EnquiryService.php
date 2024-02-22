<?php

namespace App\Services;

use App\Actions\ProductPrice\GetProductPriceAction;
use Illuminate\Database\Eloquent\Collection;

class EnquiryService
{
    public function __construct(
        private GetProductPriceAction $getProductPriceAction,
    )
    {

    }

    public function getPrices(Collection $products): Collection
    {
        $productIds = $products->pluck('id')->toArray();
        $productPrices = $this->getProductPriceAction->handle($productIds);

        return $products->map(function ($product) use ($productPrices) {
            $productPrice = $productPrices->firstWhere('product_id', $product->id);
            $product->price = $productPrice['price'] ?? 0;

            return $product;
        });
    }
}
