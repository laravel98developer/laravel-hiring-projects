<?php

namespace App\Repositories\Db;

use App\Enums\Tripe\Status;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Builder;

class TripRepository extends BaseRepository implements \App\Contracts\Repository\TripRepository
{
    protected function model(): string
    {
        return Trip::class;
    }

    public function needGetNewDeliveryTime(string $orderId): bool
    {
        return Trip::query()
            ->where('order_id', $orderId)
            ->whereHas('tripStatuses', function (Builder $query) {
                $query->whereIn('status', [
                    Status::ASSIGNED,
                    Status::PICKED,
                    Status::VENDOR_AT,
                ]);
            })->exists();
    }

    public function orderHasTrip(string $orderId): bool
    {
        return Trip::query()
            ->where('order_id', $orderId)
            ->whereHas('tripStatuses')
            ->exists();
    }
}
