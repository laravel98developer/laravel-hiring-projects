<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'code',
        'price',
        'created_at',
        'updated_at',
    ];

    public function wallets(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
