<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class DelayReportNotFound extends Exception
{
    protected $message = 'delay report not found';

    protected $code = Response::HTTP_NOT_FOUND;
}
