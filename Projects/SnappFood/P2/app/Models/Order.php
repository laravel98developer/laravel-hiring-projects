<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    use HasUlids;

    protected $casts = [
        'delivery_time' => 'datetime',
    ];

    protected $fillable = [
        'delivery_time',
        'vendor_id',
    ];

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function delayReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(DelayReport::class, 'order_id', 'id');
    }

    public function trip(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Trip::class, 'order_id', 'id');
    }
}
