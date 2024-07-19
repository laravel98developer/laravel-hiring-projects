<?php

namespace App\Contracts\Repository;

use App\Models\DelayReport;

interface DelayReportRepository extends Repository
{
    public function existOrderHasActiveDelayReport(string $orderId): bool;

    public function existActiveDelayReportForAgent(string $agentId): bool;

    public function getFifoDelayReport(): ?DelayReport;

    public function analytics(): ?object;
}
