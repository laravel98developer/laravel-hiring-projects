<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $vendor_id
 * @property mixed $delivery_time
 * @property mixed $created_at
 * @property mixed $updated_at
 */
class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'delivery_time' => $this->delivery_time?->toIso8601String(),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
