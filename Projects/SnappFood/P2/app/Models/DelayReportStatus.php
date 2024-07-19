<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DelayReportStatus extends Model
{
    use HasFactory;
    use HasUlids;

    public const UPDATED_AT = null;

    protected $fillable = [
        'status',
        'description',
        'delay_report_id',
    ];
}
