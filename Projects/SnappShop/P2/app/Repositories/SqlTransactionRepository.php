<?php

namespace App\Repositories;

use App\Interfaces\TransactionRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SqlTransactionRepository implements TransactionRepositoryInterface
{
    public function topUserWithTransactions(): JsonResponse
    {
        $topUser = DB::select('
            WITH TopUsers AS (
                SELECT
                    users.id AS user_id,
                    users.name AS user_name,
                    COUNT(*) AS transaction_count
                FROM
                    transactions
                JOIN
                    cards ON transactions.source_card_id = cards.id OR transactions.destination_card_id = cards.id
                JOIN
                    accounts ON accounts.id = cards.account_id
                JOIN
                    users ON users.id = accounts.user_id
                WHERE
                    transactions.created_at >= NOW() - INTERVAL 10 MINUTE
                GROUP BY
                    users.id, users.name
                ORDER BY
                    transaction_count DESC
                LIMIT 3
            )
            SELECT
                top_users.user_id,
                top_users.user_name,
                transactions.id AS transaction_id,
                transactions.amount,
                transactions.created_at AS transaction_created_at
            FROM
                TopUsers AS top_users
            JOIN
                cards ON cards.account_id IN (SELECT id FROM accounts WHERE user_id = top_users.user_id)
            JOIN
                transactions ON (transactions.source_card_id = cards.id OR transactions.destination_card_id = cards.id)
            WHERE
                transactions.created_at >= NOW() - INTERVAL 10 MINUTE
            ORDER BY
                top_users.transaction_count DESC, transactions.created_at DESC
            LIMIT 30;
        ');

        return response()->json($topUser);
    }
}
