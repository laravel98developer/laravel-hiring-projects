<?php

namespace App\Exceptions;

use Exception;

class ServiceException extends Exception
{
    private ?array $errors;

    /**
     * ServiceException constructor.
     *
     * @param  int  $code
     */
    public function __construct($code = 0, ?array $errors = null, ?Exception $previous = null)
    {
        parent::__construct('http call request', $code, $previous);

        $this->errors = $errors;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
