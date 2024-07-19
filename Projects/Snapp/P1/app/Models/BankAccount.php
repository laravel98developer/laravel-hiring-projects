<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BankAccount extends Model
{
    use HasFactory;

    /**
     * Get all of the bankAccountCards for the BankAccount
     */
    public function bankAccountCards(): HasMany
    {
        return $this->hasMany(BankAccountCard::class);
    }

    /**
     * Get the user that owns the BankAccount
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
