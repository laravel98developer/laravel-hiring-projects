<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'user' => $this->user,
            'product' => new ProductResource($this->product),
            'status' => $this->status,
            'comment' => $this->comment,
            'created_at' => $this->created_at ? $this->created_at->format('Y/m/d') : '',
            'updated_at' => $this->updated_at ?  $this->updated_at->format('Y/m/d') : ''
        ];
    }
}
