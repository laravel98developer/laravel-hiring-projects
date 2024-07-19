<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $delayReportStatus
 * @property mixed $created_at
 * @property mixed $updated_at
 * @property mixed $delayReportStatuses
 */
class DelayReportResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'current_status' => $this->whenLoaded(
                'delayReportStatus', fn () => $this->delayReportStatus->status
            ),
            'statuses' => $this->whenLoaded(
                'delayReportStatuses', fn () => DelayReportStatusCollection::make($this->delayReportStatuses)
            ),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
