<?php

namespace App\Http\Controllers;

use App\Enums\TripStatus;
use App\Http\Requests\DelayReportRequest;
use App\Http\Resources\OrderDelayReportResource;
use App\Jobs\ReEstimateOrderDeliveryTime;
use App\Models\Agent;
use App\Models\DelayReport;
use App\Models\Order;
use App\Models\Trip;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;

class DelayReportController extends Controller
{
    /**
     * This method stores the user's delay report if possible.
     *
     * @param DelayReportRequest $request
     * @param Order $order
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function store(DelayReportRequest $request, Order $order)
    {
        /** @var Trip $trip */
        $trip = $order->trip()->first();
        if ($trip && $trip->isNotDeliveredYet()) {
            ReEstimateOrderDeliveryTime::dispatch($order);
        }

        $order_has_not_unreviewed_delay_report = $order->delayReports()
            ->unreviewed()
            ->doesntExist();
        if ($order_has_not_unreviewed_delay_report) {
            $order->delayReports()->create();
            return response([
                'data' => null,
                'message' => 'Delay has been submitted!',
            ], Response::HTTP_CREATED);
        } else {
            return response([
                'data' => null,
                'message' => 'Unreviewed delay report can not be submitted again.',
            ], Response::HTTP_ALREADY_REPORTED);
        }
    }

    /**
     * This method assigns a delay report to a free agent.
     *
     * @throws \Throwable
     */
    public function assignDelayReport()
    {
        $oldest_unreviewed_without_agent_delay_report = DelayReport::query()
            ->oldest()
            ->unreviewed()
            ->withoutAgent()
            ->first();

        $free_agent = Agent::query()->inRandomOrder() //If we had authentication for agents, this part would be something like auth()->user
        ->whereDoesntHave('delayReports', fn(Builder $query) => $query->unreviewed())
            ->first();

        $oldest_unreviewed_without_agent_delay_report->update(['agent_id' => $free_agent->id]);

        return response([
            'data' => null,
            'message' => 'An unreviewed delay report has been assigned to you successfully.',
        ]);
    }

    /**
     * This method lists all delays of the past week for a specific vendor.
     *
     * @param Vendor $vendor
     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
     */
    public function vendorDelayReport(Vendor $vendor)
    {
        $orders = $vendor->orders()
            ->withWhereHas('lastDelayReport')
            ->with(['trip'])
            ->whereDate('created_at', '>=', now()->subWeek())
            ->get()
            ->toArray();

        foreach ($orders as $key => $order) {
            if (isset($order['trip']) && $order['trip']['status'] == TripStatus::DELIVERED) {
                $order_last_update = $order['trip']['updated_at'];
            } else {
                $order_last_update = $order['last_delay_report']['created_at'];
            }
            $orders[$key]['delay'] = Carbon::parse($order['created_at'])->diff($order_last_update);
        }

        return response(OrderDelayReportResource::collection($orders));
    }
}
