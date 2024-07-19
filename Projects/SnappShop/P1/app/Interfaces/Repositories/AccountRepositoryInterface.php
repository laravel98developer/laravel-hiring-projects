<?php

namespace App\Interfaces\Repositories;

use App\Models\Account;

interface AccountRepositoryInterface {

    public function subBalance(Account $account, $amount) : void;
    public function sumBalance(Account $account, $amount) : void;
}