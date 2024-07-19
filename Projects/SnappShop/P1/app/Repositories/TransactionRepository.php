<?php

namespace App\Repositories;

use App\Interfaces\Repositories\TransactionRepositoryInterface;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository implements TransactionRepositoryInterface {

    public function create($cardId, $destinationCardId, $amount) : Transaction {

        return Transaction::create([
            'card_id' => $cardId,
            'destination_card_id' => $destinationCardId,
            'amount' => $amount + TRANSACTION_WAGE
        ]);
    }

    public function changeStatus(Transaction $transaction, $status) : Transaction {

        $transaction->status = $status;
        $transaction->save();
        
        return $transaction;
    }
}