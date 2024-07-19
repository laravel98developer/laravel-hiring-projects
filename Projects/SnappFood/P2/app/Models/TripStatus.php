<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripStatus extends Model
{
    use HasFactory;
    use HasUlids;

    public const UPDATED_AT = null;

    protected $fillable = [
        'status',
        'trip_id',
        'description',
    ];
}
