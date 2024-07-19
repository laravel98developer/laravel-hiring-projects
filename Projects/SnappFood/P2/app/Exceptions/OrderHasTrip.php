<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class OrderHasTrip extends Exception
{
    protected $message = 'order has tripe';

    protected $code = Response::HTTP_BAD_REQUEST;
}
