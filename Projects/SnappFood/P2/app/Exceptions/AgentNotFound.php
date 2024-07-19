<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AgentNotFound extends Exception
{
    protected $message = 'agent not found';

    protected $code = Response::HTTP_NOT_FOUND;
}
