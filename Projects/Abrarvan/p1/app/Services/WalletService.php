<?php

namespace App\Services;

use App\Actions\Wallet\BalanceAction;

class WalletService
{
    private BalanceAction $balanceAction;

    public function __construct(BalanceAction $balanceAction)
    {
        $this->balanceAction = $balanceAction;
    }

    public function get(string $phone): int
    {
        return $this->balanceAction->handle($phone);
    }
}
