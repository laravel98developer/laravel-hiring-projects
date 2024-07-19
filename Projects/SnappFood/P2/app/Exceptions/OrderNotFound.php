<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class OrderNotFound extends Exception
{
    protected $message = 'order not found';

    protected $code = Response::HTTP_NOT_FOUND;
}
