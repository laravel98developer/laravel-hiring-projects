<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'product_reviews' =>$this->collection->transform(function($product_review){
                return [
                    'id' => $product_review->id,
                    'is_reviewable' => $product_review->is_reviewable,
                    'only_user_that_bought_product' => $product_review->only_user_that_bought_product,
                    'product' => new ProductResource($product_review->product),
                    'vote_avg' => $product_review->vote_avg,
                    'review_count' => $product_review->review_count,
                    'created_at' => $product_review->created_at ? $product_review->created_at->format('Y/m/d') : '',
                    'updated_at' => $product_review->updated_at ?  $product_review->updated_at->format('Y/m/d') : ''
                ];
            }),
            'pagination' => [
                'total' => $this->resource->total(),
                'count' => $this->resource->count(),
                'per_page' => $this->resource->perPage(),
                'current_page' => $this->resource->currentPage(),
                'total_pages' => $this->resource->lastPage()
            ]
        ];
    }
}
