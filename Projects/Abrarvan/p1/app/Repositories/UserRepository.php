<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository
{
    public function get(string $phone): User
    {
        return User::query()->wherePhone($phone)->first();
    }

    public function getAllByWalletIds(array $walletIds): Collection
    {
        $users = User::query()->whereHas('wallet', function ($query) use ($walletIds) {
            $query->whereIn('id', $walletIds);
        })->get();

        return collect($users);
    }
}
