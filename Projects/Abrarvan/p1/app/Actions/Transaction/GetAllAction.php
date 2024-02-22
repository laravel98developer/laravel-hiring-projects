<?php

namespace App\Actions\Transaction;

use App\Repositories\TransactionRepository;
use Illuminate\Support\Collection;

class GetAllAction
{
    private TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function handle(string $phone): Collection
    {
        return $this->transactionRepository->allByPhone($phone);
    }
}
