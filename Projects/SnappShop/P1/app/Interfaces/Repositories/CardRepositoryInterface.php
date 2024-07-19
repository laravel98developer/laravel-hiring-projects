<?php

namespace App\Interfaces\Repositories;

use App\Models\Card;

interface CardRepositoryInterface {

    public function findByCardNumber($cardNumber) : Card;
}