<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BasketCollection extends ResourceCollection
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
            'baskets' =>$this->collection->transform(function($basket){
                return [
                    'id' => $basket->id,
                    'product' => new ProviderResource($basket->product),
                    'user' => $basket->user_id,
                    'created_at' => $basket->created_at ? $basket->created_at->format('Y/m/d') : '',
                    'updated_at' => $basket->updated_at ?  $basket->updated_at->format('Y/m/d') : ''
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
