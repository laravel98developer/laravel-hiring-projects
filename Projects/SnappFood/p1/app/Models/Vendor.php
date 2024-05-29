<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function delayReports(): HasManyThrough
    {
        return $this->hasManyThrough(DelayReport::class, Order::class);
    }
}
