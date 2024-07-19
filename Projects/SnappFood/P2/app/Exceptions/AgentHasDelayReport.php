<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class AgentHasDelayReport extends Exception
{
    protected $message = 'agent has delay report';

    protected $code = Response::HTTP_BAD_REQUEST;
}
