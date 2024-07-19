<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\MoneyTransferRequest;
use App\Services\Transaction\TransactionService;

class TransactionController extends Controller
{
    public function __invoke(MoneyTransferRequest $request, TransactionService $transactionService)
    {
        $transferResult = $transactionService->transferMoney($request->input('source_card_number'), $request->input('destination_card_number'), $request->input('amount'));

        return response()->json(['message' => $transferResult['message']], $transferResult['status']);
    }
}
