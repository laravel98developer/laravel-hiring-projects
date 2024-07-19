<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wage extends Model
{
    protected $fillable = ['wage_amount'];

    public const AMOUNT = 5_000;

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public static function add(Transaction $transaction): self
    {
        $wage = new self(['wage_amount' => self::AMOUNT]);
        $wage->transaction()->associate($transaction);
        $wage->save();

        return $wage;
    }
}
