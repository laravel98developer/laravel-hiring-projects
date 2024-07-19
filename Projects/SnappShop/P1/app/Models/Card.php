<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'card_number'
    ];

    public function account() 
    {
        
        return $this->belongsTo(Account::class);
    }

    public function user() 
    {

        return $this->hasOneThrough(User::class, Account::class, 'user_id', 'id');
    }
}
