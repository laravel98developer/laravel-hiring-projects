<?php

namespace App\Http\Resources;

use App\Enums\TripStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => TripStatus::fromValue($this['status']),
            'updated_at' => $this['updated_at'],
        ];
    }
}
