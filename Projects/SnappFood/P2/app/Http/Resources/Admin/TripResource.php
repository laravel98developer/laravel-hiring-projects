<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $tripStatus
 */
class TripResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'current_status' => $this->whenLoaded(
                'tripStatus', fn () => $this->tripStatus->status
            ),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
