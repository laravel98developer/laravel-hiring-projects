<?php

namespace App\Actions\ProductPrice;

use App\Models\ProductPrice;
use Illuminate\Support\Collection;

class GetProductPriceAction
{
    public function handle(array $productIds): Collection
    {
        $prices = ProductPrice::query()
                              ->whereIn('product_id', $productIds)
                              ->get();

        return collect($prices)->map(function ($price) {
            return [
                'product_id' => $price->product_id,
                'price' => $price->price,
            ];
        });
    }
}
