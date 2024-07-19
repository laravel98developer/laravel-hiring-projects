<?php

namespace App\Validate\StoreDelayReport;

use App\Contracts\Repository\DelayReportRepository;
use App\Contracts\Validate\StoreDelayReport;
use App\Exceptions\OrderHasPendingDelayReport;
use App\Models\Order;
use Closure;

class CheckOrderDelayReport implements StoreDelayReport
{
    public function __construct(
        private readonly DelayReportRepository $delayReportRepository
    ) {
    }

    public function handle(Order $order, Closure $next)
    {
        $existOrderHasActiveDelayReport = $this->delayReportRepository->existOrderHasActiveDelayReport($order->id);
        throw_if($existOrderHasActiveDelayReport, OrderHasPendingDelayReport::class);

        return $next($order);
    }
}
