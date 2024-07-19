<?php

namespace App\Http\Controllers\Agent;

use App\Actions\AssignDelayReportAction;
use App\Contracts\Repository\DelayReportRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\DelayReportAssignRequest;
use App\Http\Resources\Agent\AnalyticsCollection;
use App\Http\Resources\Agent\DelayReportResource;

class DelayReportController extends Controller
{
    public function __construct(
        private readonly DelayReportRepository $delayReportRepository,
    ) {
    }

    public function assign(DelayReportAssignRequest $reportAssignRequest): DelayReportResource
    {
        return DelayReportResource::make(
            AssignDelayReportAction::make()->handle(
                $reportAssignRequest->get('agent_id')
            )
        );
    }

    public function analytics(): AnalyticsCollection
    {
        return AnalyticsCollection::make(
            $this->delayReportRepository->analytics()
        );
    }
}
