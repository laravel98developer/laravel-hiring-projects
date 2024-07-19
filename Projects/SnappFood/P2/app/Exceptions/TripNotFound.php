<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class TripNotFound extends Exception
{
    protected $message = 'trip not found';

    protected $code = Response::HTTP_NOT_FOUND;
}
