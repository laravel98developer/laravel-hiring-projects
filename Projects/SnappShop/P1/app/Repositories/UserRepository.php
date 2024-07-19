<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use App\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface {

    public function getLastUsersWithTransactions() : Collection {

        return User::with(['transactions' => function ($q) {

            $q->with('card', 'destinationCard');
            $q->where('transactions.created_at', '>', Carbon::now()->subMinutes(10))
                ->where('transactions.status', TRANSACTION_STATUS_SUCCEED)
                ->orderBy('transactions.created_at', 'DESC');
        }])->withCount('transactions')
        ->orderByDesc('transactions_count')
        ->limit(3)
        ->get();
    }
}