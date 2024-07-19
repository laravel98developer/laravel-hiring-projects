<?php

namespace App\Interfaces\Services;

use App\Http\Requests\TransactionRequest;

interface DoTransactionServiceInterface {

    public function ready(TransactionRequest $request) : void;
    public function checkBalance($amount) : bool;
    public function execute(TransactionRequest $request) : void;
    public function conflict() : void;
}