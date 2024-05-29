<?php

namespace App\Models;

use App\Enums\TripStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
    ];

    protected $casts = [
        'status' => TripStatus::class
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function isNotDeliveredYet(): bool
    {
        return
            $this->status == TripStatus::ASSIGNED ||
            $this->status == TripStatus::AT_VENDOR ||
            $this->status == TripStatus::PICKED;
    }
}
