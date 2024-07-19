<?php

namespace App\Actions;

use App\Contracts\Repository\DelayReportRepository;
use App\Exceptions\DelayReportNotFound;
use App\Models\DelayReport;
use App\Validate\AssignDelayReport;
use Illuminate\Routing\Pipeline;
use Lorisleiva\Actions\Concerns\AsAction;

class AssignDelayReportAction
{
    use AsAction;

    private array $validatePipes = [
        AssignDelayReport\CheckAgentExist::class,
        AssignDelayReport\CheckAgentHasDelayReport::class,
    ];

    public function __construct(
        private readonly DelayReportRepository $delayReportRepository,
    ) {
    }

    public function handle(string $agentId): DelayReport
    {
        $this->validate($agentId);

        $delayReport = $this->delayReportRepository->getFifoDelayReport();
        throw_if(empty($delayReport), DelayReportNotFound::class);

        $this->delayReportRepository->update([
            'agent_id' => $agentId,
        ], $delayReport->id);

        $delayReport->agent_id = $agentId;

        return $delayReport;
    }

    public function validate(string $agentId): void
    {
        app(Pipeline::class)
            ->send($agentId)
            ->through($this->validatePipes)
            ->thenReturn();
    }
}
