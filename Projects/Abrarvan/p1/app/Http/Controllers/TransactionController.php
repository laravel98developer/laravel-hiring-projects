<?php

namespace App\Http\Controllers;


use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function allByPhone(Request $request): TransactionResource
    {
        $response = $this->transactionService->allByPhone($request->phone);

        return new TransactionResource($response);
    }
}
