<?php

namespace App\Exceptions;

use Exception;

class SameAccountTransactionException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct(__('message.transaction.same_account_error'), 403);
    }
}
