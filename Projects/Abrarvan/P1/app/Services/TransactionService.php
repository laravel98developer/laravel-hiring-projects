<?php

namespace App\Services;

use App\Actions\Transaction\GetAllAction;
use Illuminate\Support\Collection;

class TransactionService
{
    private GetAllAction $getAllAction;

    public function __construct(GetAllAction $getAllAction)
    {
        $this->getAllAction = $getAllAction;
    }

    public function allByPhone(string $phone): Collection
    {
        return $this->getAllAction->handle($phone);
    }
}
