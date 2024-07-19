<?php

namespace App\Repositories\Db;

use App\Enums\DeliveryReport\Status as DeliveryReportStatus;
use App\Models\DelayReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DelayReportRepository extends BaseRepository implements \App\Contracts\Repository\DelayReportRepository
{
    protected function model(): string
    {
        return DelayReport::class;
    }

    public function existOrderHasActiveDelayReport(string $orderId): bool
    {
        return $this->model->query()
            ->where('order_id', $orderId)
            ->whereHas('delayReportStatus', function (Builder $query) {
                $query->whereIn('status', [
                    DeliveryReportStatus::CREATED,
                    DeliveryReportStatus::PENDING,
                ]);
            })->exists();
    }

    public function analytics(): ?object
    {
        return DB::table('delay_reports')
            ->selectRaw('
             vendors.id AS vendor_id,
             SUM(delay_reports.delay_minute) AS delay_minute_sum
             ')
            ->join('orders', 'delay_reports.order_id', 'orders.id')
            ->join('vendors', 'orders.vendor_id', 'vendors.id')
            ->groupBy('vendors.id')
            ->get();
    }

    public function existActiveDelayReportForAgent(string $agentId): bool
    {
        return DelayReport::query()
            ->where('agent_id', $agentId)
            ->whereHas('delayReportStatus', function (Builder $query) {
                $query->where('status', '!=', DeliveryReportStatus::COMPLETED);
            })->exists();
    }

    public function getFifoDelayReport(): ?DelayReport
    {
        return DelayReport::whereNull('agent_id')
            ->whereHas('delayReportStatus', function (Builder $query) {
                $query->where('status', DeliveryReportStatus::CREATED);
            })->orderByDesc('id')
            ->first();
    }
}
