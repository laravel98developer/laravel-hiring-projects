<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\LastTransactionsResource;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Interfaces\Services\DoTransactionServiceInterface;
use Illuminate\Http\Response;

class TransactionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request, DoTransactionServiceInterface $transaction)
    {

        $transaction->ready($request);

        // check if the first card account have enough amount of credit for transaction and wage
        if(!$transaction->checkBalance($request->amount)){

            return response([
                'success' => false,
                'message' => 'Account Balance is not enough!'
            ], Response::HTTP_NOT_ACCEPTABLE);
        }

        try {

            // change status on database, make a wage record, transfer credits and send sms to users 
            $transaction->execute($request);

        } catch (\Throwable $th) {

            // change transaction status to error on database
            $transaction->conflict();

            return response([
                'success' => false,
                'message' => 'Error: something went wrong! ' . $th->getMessage()
            ], Response::HTTP_CONFLICT);
        }

        return response([
            'success' => true,
            'message' => 'payment is successfull.'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function showLastTransactions(UserRepositoryInterface $userRepository)
    {
        
        try {
            
            return LastTransactionsResource::make($userRepository->getLastUsersWithTransactions());
        } catch (\Throwable $th) {
            
            return response([
                'success' => false,
                'message' => 'Error: something went wrong! ' . $th->getMessage()
            ], Response::HTTP_CONFLICT);
        }
    }
}
