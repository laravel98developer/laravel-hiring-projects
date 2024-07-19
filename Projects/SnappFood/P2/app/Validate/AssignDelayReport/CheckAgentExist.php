<?php

namespace App\Validate\AssignDelayReport;

use App\Contracts\Repository\AgentRepository;
use App\Contracts\Validate\AssignDelayReport;
use App\Exceptions\AgentNotFound;
use Closure;

class CheckAgentExist implements AssignDelayReport
{
    public function __construct(
        private readonly AgentRepository $agentRepository,
    ) {
    }

    public function handle(string $agentId, Closure $next)
    {
        $agentExist = $this->agentRepository->exist($agentId);
        throw_if(empty($agentExist), AgentNotFound::class);

        return $next($agentId);
    }
}
