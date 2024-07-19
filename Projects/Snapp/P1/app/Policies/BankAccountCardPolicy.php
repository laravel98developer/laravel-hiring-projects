<?php

namespace App\Policies;

use App\Models\BankAccountCard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BankAccountCardPolicy
{
    public function create(User $user, BankAccountCard $bankAccountCard)
    {
        return $user->id === $bankAccountCard->user_id
            ? Response::allow()
            : Response::deny(__('message.transaction.403'));
    }
}
