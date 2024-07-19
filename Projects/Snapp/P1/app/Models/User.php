<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Korridor\LaravelHasManyMerged\HasManyMerged;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Korridor\LaravelHasManyMerged\HasManyMergedRelation;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasManyMergedRelation;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'mobile',
    ];

    /**
     * Get all of the bankAccounts for the User
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    /**
     * Get all of the bankAccountCards for the User
     */
    public function bankAccountCards(): HasMany
    {
        return $this->hasMany(BankAccountCard::class);
    }

    /**
     * Get all of the sent transactions for the User
     */
    public function sentTransactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, BankAccountCard::class, 'user_id', 'sender_card_id');
    }

    /**
     * Get all of the received transactions for the User
     */
    public function receivedTransactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, BankAccountCard::class, 'user_id', 'receiver_card_id');
    }

    /**
     * @return HasManyMerged|Message
     */
    public function transactions(): HasManyMerged
    {
        return $this->hasManyMerged(Transaction::class, ['sender_card_id', 'receiver_card_id']);
    }

    /**
     * Scope a query to include users with most transactions.
     */
    public function scopeUsersWithMostTransactions($query, int $userNumber, int $transactionNumber): void
    {
        $query->withCount(['transactions'])
            ->with(['transactions' => function ($query) use ($transactionNumber) {
                $query->limit($transactionNumber);
            }])
            ->orderBy('transactions_count', 'desc')
            ->limit($userNumber);
    }

    /**
     * Scope a query to only include users with a specific mobile.
     */
    public function scopeWhereMobile($query, string $mobile): void
    {
        $query->where('mobile', $mobile);
    }
}
