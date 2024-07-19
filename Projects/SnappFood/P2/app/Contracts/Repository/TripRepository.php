<?php

namespace App\Contracts\Repository;

interface TripRepository extends Repository
{
    public function needGetNewDeliveryTime(string $orderId): bool;

    public function orderHasTrip(string $orderId): bool;
}
