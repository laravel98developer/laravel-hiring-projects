<?php

namespace App\Repositories;

use App\Models\Account;
use App\Interfaces\Repositories\AccountRepositoryInterface;

class AccountRepository implements AccountRepositoryInterface {

    public function subBalance(Account $account, $amount) : void {

        $account->balance -= $amount + TRANSACTION_WAGE;
        $account->save();
    }

    public function sumBalance(Account $account, $amount) : void {

        $account->balance += $amount;
        $account->save();
    }
}