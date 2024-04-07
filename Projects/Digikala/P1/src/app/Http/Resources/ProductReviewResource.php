<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'is_reviewable' => $this->is_reviewable,
            'only_user_that_bought_product' => $this->only_user_that_bought_product,
            'product' => new ProductResource($this->product),
            'vote_avg' => $this->vote_avg,
            'review_count' => $this->review_count,
            'reviews' => $this->reviews,
            'created_at' => $this->created_at ? $this->created_at->format('Y/m/d') : '',
            'updated_at' => $this->updated_at ?  $this->updated_at->format('Y/m/d') : ''
        ];
    }
}
