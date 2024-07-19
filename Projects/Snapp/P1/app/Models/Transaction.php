<?php

namespace App\Models;

use App\Models\Enums\TransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_card_id',
        'receiver_card_id',
        'amount',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => TransactionStatusEnum::class,
    ];

    protected static function booted()
    {
        static::creating(function ($transaction) {
            do {
                $referenceId = mt_rand(1_000_000_000, 9_999_999_999);
            } while (static::where('reference_id', $referenceId)->exists());

            $transaction->reference_id = $referenceId;
        });
    }

    /**
     * Get the transactionWage associated with the Transaction
     */
    public function transactionWage(): HasOne
    {
        return $this->hasOne(TransactionWage::class);
    }

    /**
     * Get the sender that owns the Transaction
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(BankAccountCard::class, 'sender_card_id');
    }

    /**
     * Get the receiver that owns the Transaction
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(BankAccountCard::class, 'receiver_card_id');
    }
}
