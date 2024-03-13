<?php

namespace App\Repositories;


use App\Models\Wallet;

class WalletRepository
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function balance(string $phone): int
    {
        $user = $this->userRepository->get($phone);

        return $user->wallet->balance ?? 0;
    }

    public function getByUserId(int $userId): Wallet
    {
        return Wallet::query()->where('user_id', $userId)->first();
    }

    public function getByPhone(string $phone): Wallet
    {
        $userId = $this->userRepository->get($phone)->id;

        return $this->getByUserId($userId);
    }

    public function charge(string $phone, int $price): bool
    {
        $user = $this->userRepository->get($phone);

        return Wallet::query()
            ->where('user_id', $user->id)
            ->increment('balance', $price);
    }
}
