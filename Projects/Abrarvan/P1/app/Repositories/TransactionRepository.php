<?php

namespace App\Repositories;


use App\Models\Transaction;
use Illuminate\Support\Collection;

class TransactionRepository
{
    private UserRepository $userRepository;
    private WalletRepository $walletRepository;

    public function __construct(UserRepository $userRepository, WalletRepository $walletRepository)
    {
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
    }

    public function allByPhone(string $phone): Collection
    {
        $user = $this->userRepository->get($phone);
        $transactions = $this->walletRepository->getByUserId($user->id)->transactions;

        return collect($transactions);
    }

    public function all(array $request): Collection
    {
        return Transaction::query()
            ->when(!empty($request['code']), fn($query) => $query->where('code' , $request['code']))
            ->get()
            ->collect();
    }
}
