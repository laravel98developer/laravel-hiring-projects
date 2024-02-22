<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'provider_id',
        'name',
        'quantity',
        'status',
        'comment_status',
        'comment_status_after_buy',
        'vote_status',
        'vote_status_after_buy',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'user_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(ProductPrice::class, 'product_id');
    }
}
