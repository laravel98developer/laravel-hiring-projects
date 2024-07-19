<?php

namespace App\Http\Resources\Agent;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $vendor_id
 * @property mixed $delay_minute_sum
 */
class AnalyticsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'vendor_id' => $this->vendor_id,
            'delay_minutes' => $this->delay_minute_sum,
        ];
    }
}
