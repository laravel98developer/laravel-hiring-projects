<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UsersResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LastTransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'time_limit' => '10 minutes',
            'users' => UsersResource::collection($this),
        ];
    }
}
