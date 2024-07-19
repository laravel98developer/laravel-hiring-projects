<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentTripStatus extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'status',
        'description',
    ];
}
