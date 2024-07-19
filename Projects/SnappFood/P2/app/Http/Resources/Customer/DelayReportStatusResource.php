<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $status
 * @property mixed $delayReportStatus
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $description
 */
class DelayReportStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'description' => $this->description,
            'created_at' => $this->created_at?->toIso8601String(),
        ];
    }
}
