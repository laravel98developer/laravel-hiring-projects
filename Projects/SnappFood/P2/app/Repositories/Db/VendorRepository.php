<?php

namespace App\Repositories\Db;

use App\Models\Vendor;

class VendorRepository extends BaseRepository implements \App\Contracts\Repository\VendorRepository
{
    protected function model(): string
    {
        return Vendor::class;
    }
}
