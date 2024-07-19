<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class OrderDoesNotHaveDelay extends Exception
{
    protected $message = 'order does not have delay';

    protected $code = Response::HTTP_BAD_REQUEST;
}
