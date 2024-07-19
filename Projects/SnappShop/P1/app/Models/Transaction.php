<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'card_id',
        'destination_card_id',
        'amount',
    ];

    public function card()
    {
        
        return $this->belongsTo(Card::class);
    }
    
    public function destinationCard()
    {
        
        return $this->belongsTo(Card::class, 'destination_card_id', 'id');
    }
}
