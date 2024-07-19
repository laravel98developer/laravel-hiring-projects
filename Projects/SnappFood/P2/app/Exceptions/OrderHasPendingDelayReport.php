<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class OrderHasPendingDelayReport extends Exception
{
    protected $message = 'order has delay report';

    protected $code = Response::HTTP_BAD_REQUEST;
}
