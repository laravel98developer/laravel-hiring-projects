<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccountCard extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the BankAccountCard
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the BankAccount that owns the BankAccountCard
     */
    public function bankAccount(): BelongsTo
    {
        return $this->belongsTo(BankAccount::class);
    }
}
