<?php

namespace App\Http\Resources;

use App\Models\DelayReport;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDelayReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'delivery_time' => $this['delivery_time'],
            'last_delay_report' => LastDelayReportResource::make($this['last_delay_report']),
            'trip' => TripResource::make($this['trip']),
            'delay' => DelayReport::toDateTimeString($this['delay']),
        ];
    }
}
