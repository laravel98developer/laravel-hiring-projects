<?php

namespace App\Exceptions;

use Exception;

class InsufficientBalanceTransactionException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct(__('message.transaction.insufficient_balance'), 403);
    }
}
