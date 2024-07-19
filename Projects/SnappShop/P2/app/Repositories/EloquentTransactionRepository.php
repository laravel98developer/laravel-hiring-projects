<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class EloquentTransactionRepository implements TransactionRepositoryInterface
{
    public function topUserWithTransactions(): JsonResponse
    {
        $usersWithMostTransactions = DB::table('users')
            ->select('users.*', DB::raw('COUNT(transactions.id) as transaction_count'))
            ->join('accounts', 'users.id', '=', 'accounts.user_id')
            ->join('cards', 'accounts.id', '=', 'cards.account_id')
            ->join('transactions', function ($join) {
                $join->on('cards.id', '=', 'transactions.source_card_id')
                    ->orWhere('cards.id', '=', 'transactions.destination_card_id');
            })
            ->whereBetween('transactions.created_at', [now()->subMinutes(10), now()])
            ->groupBy('users.id')
            ->orderByDesc('transaction_count')
            ->limit(3)
            ->get();

        $userIds = $usersWithMostTransactions->pluck('id');

        $usersWithTransactions = User::whereIn('id', $userIds)
            ->with([
                'accounts.cards.sourceTransactions' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(10);
                },
                'accounts.cards.destinationTransactions' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(10);
                },
            ])
            ->get();

        return response()->json($usersWithTransactions);
    }
}
