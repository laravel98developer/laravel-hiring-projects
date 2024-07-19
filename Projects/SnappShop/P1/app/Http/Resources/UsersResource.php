<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\TransactionsResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'name' => $this->name,
            'phone' => $this->phone,
            'transactions' => TransactionsResource::collection($this->transactions),
        ];
    }
}
