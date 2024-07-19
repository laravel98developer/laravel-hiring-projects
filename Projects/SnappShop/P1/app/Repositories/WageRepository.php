<?php

namespace App\Repositories;

use App\Interfaces\Repositories\WageRepositoryInterface;
use App\Models\Wage;

class WageRepository implements WageRepositoryInterface {

    public function create($transactionID) : Wage {

        return Wage::create([
            'transaction_id' => $transactionID,
            'amount' => TRANSACTION_WAGE,
        ]);
    }
}
