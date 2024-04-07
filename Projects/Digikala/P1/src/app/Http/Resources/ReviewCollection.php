<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
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
            'reviews' =>$this->collection->transform(function($review){
                return [
                    'id' => $review->id,
                    'user' => $review->user,
                    'product' => new ProductResource($review->product),
                    'status' => $review->status,
                    'comment' => $review->comment,
                    'created_at' => $review->created_at ? $review->created_at->format('Y/m/d') : '',
                    'updated_at' => $review->updated_at ?  $review->updated_at->format('Y/m/d') : ''
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
