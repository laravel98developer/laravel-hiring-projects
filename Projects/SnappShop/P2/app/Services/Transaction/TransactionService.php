<?php

namespace App\Services\Transaction;

use App\Jobs\SendSms;
use App\Models\Card;
use App\Models\Transaction;
use App\Models\Wage;
use App\Services\SmsService\SmsServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionService
{
    public function transferMoney(string $sourceCardNumber, string $destinationCardNumber, int $amount)
    {
        DB::beginTransaction();

        try {
            $sourceCard = Card::where('card_number', $sourceCardNumber)->lockForUpdate()->first();
            $destinationCard = Card::where('card_number', $destinationCardNumber)->lockForUpdate()->first();

            if ($sourceCard->balance < $amount + Wage::AMOUNT) {
                return ['message' => __('messages.transfer.insufficient-balance'), 'status' => JsonResponse::HTTP_BAD_REQUEST];
            }

            $sourceCard->decrement('balance', $amount + Wage::AMOUNT);
            $sourceCard->account->decrement('current_balance', $amount + Wage::AMOUNT);
            $destinationCard->increment('balance', $amount);
            $destinationCard->account->increment('current_balance', $amount);

            $transaction = Transaction::add($sourceCard, $destinationCard, $amount);
            Wage::add($transaction);

            $smsClient = app(SmsServiceInterface::class);
            dispatch(new SendSms($sourceCard->account->user->phone, __('messages.sms.source', ['amount' => $amount]), $smsClient))->afterCommit();
            dispatch(new SendSms($destinationCard->account->user->phone, __('messages.sms.destination', ['amount' => $amount]), $smsClient))->afterCommit();

            DB::commit();

            return ['message' => __('messages.transfer.success'), 'status' => JsonResponse::HTTP_OK];
        } catch (\Exception $e) {
            Log::error('Transfer error: '.$e->getMessage());
            DB::rollback();

            return ['message' => __('messages.transfer.fail'), 'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
