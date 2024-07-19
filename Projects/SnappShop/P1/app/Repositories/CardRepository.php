<?php

namespace App\Repositories;

use App\Models\Card;
use App\Interfaces\Repositories\CardRepositoryInterface;

class CardRepository implements CardRepositoryInterface {

    public function findByCardNumber($cardNumber) : Card {

        return Card::where('card_number', $cardNumber)->with('account')->first();
    }
}