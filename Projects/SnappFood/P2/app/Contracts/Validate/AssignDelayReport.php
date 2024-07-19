<?php

namespace App\Contracts\Validate;

use Closure;

interface AssignDelayReport
{
    public function handle(string $agentId, Closure $next);
}
