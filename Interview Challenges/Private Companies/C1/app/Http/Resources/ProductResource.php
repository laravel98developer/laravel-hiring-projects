<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'uuid'                     => $this->uuid,
            'provider'                 => ProviderResource::make($this->provider),
            'name'                     => $this->name,
            'quantity'                 => $this->quantity,
            'status'                   => $this->status,
            'comment_status'           => $this->comment_status,
            'comment_status_after_buy' => $this->comment_status_after_buy,
            'vote_status'              => $this->vote_status,
            'vote_status_after_buy'    => $this->vote_status_after_buy,
            'price'                    => $this->price,
            'comments'                 => $this->comments ?? [],
            'total_comments'           => $this->total_comments ?? 0,
            'votes'                    => $this->votes ?? [],
            'total_votes'              => $this->total_votes ?? 0,
            'avg_votes'                => $this->avg_votes ?? 0,
            'created_at'               => $this->created_at,
            'updated_at'               => $this->updated_at,
        ];
    }
}
