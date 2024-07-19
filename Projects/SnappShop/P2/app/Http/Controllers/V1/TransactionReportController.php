<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Interfaces\TransactionRepositoryInterface;

class TransactionReportController extends Controller
{
    public function __construct(public TransactionRepositoryInterface $transactionRepository)
    {
    }

    public function __invoke()
    {
        return $this->transactionRepository->topUserWithTransactions();
    }
}
