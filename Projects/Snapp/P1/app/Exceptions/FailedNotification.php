<?php

namespace App\Exceptions;

use Exception;

class FailedNotification extends Exception
{
    /**
     * {@inheritdoc}
     */
    public function __construct(?string $message, ?int $code)
    {
        parent::__construct($message ?? '', $code ?? 500);
    }
}
