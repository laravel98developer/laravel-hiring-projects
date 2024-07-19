<?php

namespace App\Repositories\Db;

use App\Models\TripStatus;

class TripStatusRepository extends BaseRepository implements \App\Contracts\Repository\TripStatusRepository
{
    protected function model(): string
    {
        return TripStatus::class;
    }
}
