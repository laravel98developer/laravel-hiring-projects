<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;
    use HasUlids;

    protected $fillable = [
        'order_id',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function tripStatuses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TripStatus::class, 'trip_id', 'id');
    }

    public function tripStatus(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(CurrentTripStatus::class, 'trip_id', 'id');
    }
}
