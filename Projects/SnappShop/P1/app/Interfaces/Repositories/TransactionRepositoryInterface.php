<?php

namespace App\Interfaces\Repositories;

use App\Models\Transaction;

interface TransactionRepositoryInterface {

    public function create($cardId, $destinationCardId, $amount) : Transaction;
    public function changeStatus(Transaction $transaction, $status) : Transaction;
}