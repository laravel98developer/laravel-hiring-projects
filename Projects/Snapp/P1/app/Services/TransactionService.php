<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceTransactionException;
use App\Exceptions\SameAccountTransactionException;
use App\Models\BankAccountCard;
use App\Models\Enums\TransactionStatusEnum;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\DepositTransactionNotification;
use App\Notifications\WithdrawTransactionNotification;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    public function create(
        User $senderUser,
        BankAccountCard $senderBankAccountCard,
        string $receiverCardNumber,
        int $amount
    ): Transaction {
        $receiverBankAccountCard = BankAccountCard::firstWhere('card_number', $receiverCardNumber);

        try {
            DB::beginTransaction();

            $senderBankAccount = $senderBankAccountCard->bankAccount()->lockForUpdate()->first();
            $receiverBankAccount = $receiverBankAccountCard->bankAccount()->lockForUpdate()->first();

            throw_if($receiverBankAccountCard->bankAccount->is($senderBankAccount), SameAccountTransactionException::class);

            throw_if($amount > $senderBankAccount->balance, InsufficientBalanceTransactionException::class);

            $senderBankAccount->decrement('balance', $amount);
            $receiverBankAccount->increment('balance', $amount);
            $transaction = Transaction::create([
                'sender_card_id' => $senderBankAccountCard->id,
                'receiver_card_id' => $receiverBankAccountCard->id,
                'amount' => $amount,
                'status' => TransactionStatusEnum::Done,
            ]);
            $transaction->transactionWage()->create([
                'amount' => 5_000,
            ]);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::critical('An error occurred while doing the transaction.', ['exception' => $exception->getMessage()]);
            throw $exception;
        }

        $senderUser->notify(new WithdrawTransactionNotification(
            accountNumber: $senderBankAccount->account_number,
            amount: number_format($amount),
            method: 'درگاه پرداخت',
            balance: $senderBankAccount->balance,
            dateTime: $dateTime = verta($transaction->created_at)->format('Y/m/d H:i')
        ));

        $receiverBankAccountCard->user->notify(new DepositTransactionNotification(
            accountNumber: $receiverBankAccount->account_number,
            amount: number_format($amount),
            method: 'درگاه پرداخت',
            balance: $receiverBankAccount->balance + $amount,
            dateTime: $dateTime
        ));

        return $transaction;
    }

    public function topUsers(int $userNumber, int $transactionNumber): Collection
    {
        return User::usersWithMostTransactions(
            userNumber: $userNumber,
            transactionNumber: $transactionNumber
        )->get();
    }
}
