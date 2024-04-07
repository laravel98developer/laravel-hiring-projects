<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BasketResource extends JsonResource
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
            'product' => new ProviderResource($this->product),
            'user' => $this->user_id,
            'created_at' => $this->created_at ? $this->created_at->format('Y/m/d') : '',
            'updated_at' => $this->updated_at ?  $this->updated_at->format('Y/m/d') : ''
        ];
    }
}
