<?php

namespace App\Actions\Wallet;

use App\Repositories\WalletRepository;

class ChargeAction
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function handle(string $phone, int $price): bool
    {
        return $this->walletRepository->charge($phone, $price);
    }
}
