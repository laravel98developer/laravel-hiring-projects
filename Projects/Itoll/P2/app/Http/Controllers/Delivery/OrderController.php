<?php

namespace App\Http\Controllers\Delivery;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderDeliveryRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\OrderShowResource;
use App\Jobs\CallWebHookJob;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(protected OrderRepositoryInterface $repository)
    {
    }

    public function index(): JsonResponse
    {
        return OrderShowResource::collection(
            $this->repository->getByStatus(OrderStatusEnum::WAITING)
        )->response()->setStatusCode(200);
    }

    public function accept(int $orderId, OrderDeliveryRequest $request): JsonResponse
    {
        $order = $this->repository->findByIdOrFail($orderId);
        if ($order->status !== OrderStatusEnum::WAITING) {
            return EmptyResource::make([
                'message' => __('The order is not in waiting status')
            ])->response()->setStatusCode(403);
        }

        $this->repository->accept($orderId, $request->attributes->get('delivery_id'));

        CallWebHookJob::dispatch(
            $orderId,
            $request->input('delivery_latitude'),
            $request->input('delivery_longitude')
        );

        return EmptyResource::make([
            'message' => __('The order is accepted')
        ])->response()->setStatusCode(201);
    }

    public function delivering(int $orderId, OrderDeliveryRequest $request): JsonResponse
    {
        $order = $this->repository->findByIdOrFail($orderId);
        if ($order->status !== OrderStatusEnum::ACCEPTED) {
            return EmptyResource::make([
                'message' => __('The order is not in accepted status')
            ])->response()->setStatusCode(403);
        }
        if ($order->delivery_id !== request()->attributes->get('delivery_id')) {
            return EmptyResource::make([
                'message' => __('The order is not in yours')
            ])->response()->setStatusCode(403);
        }
        $this->repository->updateStatus($orderId, OrderStatusEnum::DELIVERING);

        CallWebHookJob::dispatch(
            $orderId,
            $request->input('delivery_latitude'),
            $request->input('delivery_longitude')
        );

        return EmptyResource::make([
            'message' => __('The order is delivering now')
        ])->response()->setStatusCode(201);
    }

    public function delivered(int $orderId, OrderDeliveryRequest $request): JsonResponse
    {
        $order = $this->repository->findByIdOrFail($orderId);
        if ($order->status !== OrderStatusEnum::DELIVERING) {
            return EmptyResource::make([
                'message' => __('The order is not in delivering status')
            ])->response()->setStatusCode(403);
        }
        if ($order->delivery_id !== request()->attributes->get('delivery_id')) {
            return EmptyResource::make([
                'message' => __('The order is not in yours')
            ])->response()->setStatusCode(403);
        }
        $this->repository->updateStatus($orderId, OrderStatusEnum::DELIVERED);

        CallWebHookJob::dispatch(
            $orderId,
            $request->input('delivery_latitude'),
            $request->input('delivery_longitude')
        );

        return EmptyResource::make([
            'message' => __('The order is delivered')
        ])->response()->setStatusCode(201);
    }
}
