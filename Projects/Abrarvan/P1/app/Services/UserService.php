<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Collection;

class UserService
{
    const SUCCESS = 'Success';

    private TransactionRepository $transactionRepository;
    private UserRepository $userRepository;

    public function __construct(TransactionRepository $transactionService, UserRepository $userRepository)
    {
        $this->transactionRepository = $transactionService;
        $this->userRepository = $userRepository;
    }

    public function successTransactions(string $code = null): Collection
    {
        $transactions = $this->transactionRepository->all([
            'code' => $code
        ]);

        $walletIds = $transactions->pluck('wallet_id')->unique()->toArray();

        return $this->userRepository->getAllByWalletIds($walletIds);
    }
}
