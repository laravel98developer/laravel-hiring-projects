<?php

namespace App\Actions\Wallet;

use App\Repositories\WalletRepository;

class BalanceAction
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function handle(string $phone): int
    {
        return $this->walletRepository->balance($phone);
    }
}
