<?php

namespace App\Validate\AssignDelayReport;

use App\Contracts\Validate\AssignDelayReport;
use App\Exceptions\AgentHasDelayReport;
use App\Repositories\Db\DelayReportRepository;
use Closure;

class CheckAgentHasDelayReport implements AssignDelayReport
{
    public function __construct(
        private readonly DelayReportRepository $delayReportRepository,
    ) {
    }

    public function handle(string $agentId, Closure $next)
    {
        $agentHasActiveDelayReport = $this->delayReportRepository->existActiveDelayReportForAgent($agentId);
        throw_if($agentHasActiveDelayReport, AgentHasDelayReport::class);

        return $next($agentId);
    }
}
