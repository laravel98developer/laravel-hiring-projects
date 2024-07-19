<?php

namespace App\Actions;

use App\Contracts\Repository\DelayReportRepository;
use App\Contracts\Repository\DelayReportStatusRepository;
use App\Contracts\Repository\OrderRepository;
use App\Contracts\Repository\TripRepository;
use App\Enums\DeliveryReport\Status as DeliveryReportStatus;
use App\Models\DelayReport;
use App\Models\Order;
use App\Service\MockDelay\GetMockDelayTimeRequest;
use App\Validate\StoreDelayReport;
use Illuminate\Routing\Pipeline;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreDelayReportAction
{
    use AsAction;

    private array $validatePipes = [
        StoreDelayReport\CheckOrderExist::class,
        StoreDelayReport\CheckOrderHasDelay::class,
        StoreDelayReport\CheckOrderDelayReport::class,
    ];

    public function __construct(
        private readonly OrderRepository $orderRepository,
        private readonly DelayReportRepository $delayReportRepository,
        private readonly TripRepository $tripRepository,
        private readonly DelayReportStatusRepository $delayReportStatusRepository,
    ) {
    }

    public function handle(
        string $orderId
    ): DelayReport {
        $order = $this->orderRepository->find($orderId);

        $this->validate($order);

        $needGetNewDeliveryTime = $this->tripRepository->needGetNewDeliveryTime($order->id);
        $delayReport = DB::transaction(function () use ($needGetNewDeliveryTime, $order) {
            $delayReport = $this->delayReportRepository->create([
                'order_id' => $order->id,
                'delay_minute' => (int) $order->delivery_time->diffInMinutes(now()),
            ]);

            $this->delayReportStatusRepository->create([
                'status' => DeliveryReportStatus::CREATED,
                'delay_report_id' => $delayReport->id,
            ]);

            if ($needGetNewDeliveryTime) {
                $newDelayTimeResponse = GetMockDelayTimeRequest::build()->send();
                $newDelayTime = now()->addMinutes(
                    $newDelayTimeResponse->json('data.delay_time')
                );

                $this->orderRepository->update([
                    'delivery_time' => $newDelayTime,
                ], $order->id);

                $this->delayReportStatusRepository->create([
                    'status' => DeliveryReportStatus::COMPLETED,
                    'delay_report_id' => $delayReport->id,
                    'description' => __('ADD_NEW_TIME'),
                ]);

                $delayReport->delivery_time = $newDelayTime;
            }

            return $delayReport;
        });

        $delayReport->load('delayReportStatus', 'delayReportStatuses');

        return $delayReport;
    }

    public function validate(Order $order): void
    {
        app(Pipeline::class)
            ->send($order)
            ->through($this->validatePipes)
            ->thenReturn();
    }
}
