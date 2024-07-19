<?php

namespace App\Repositories\Db;

use App\Models\DelayReportStatus;

class DelayReportStatusRepository extends BaseRepository implements \App\Contracts\Repository\DelayReportStatusRepository
{
    protected function model(): string
    {
        return DelayReportStatus::class;
    }
}
