<?php

namespace App\Http\Controllers\Supply;

use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Enums\OrderStatusEnum;
use App\Helpers\DtoHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\OrderShowResource;
use App\Http\Resources\OrderStoreResource;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function __construct(protected OrderRepositoryInterface $repository)
    {
    }

    public function index(): JsonResponse
    {
        return OrderShowResource::collection(
            $this->repository->getBySupplierId(request()->attributes->get('supplier_id'))
        )->response()->setStatusCode(200);
    }

    public function store(OrderStoreRequest $request): JsonResponse
    {
        $dto = DtoHelper::requestToOrderStoreDto($request);

        return OrderStoreResource::make($this->repository->store($dto))->response()->setStatusCode(201);
    }

    public function destroy(int $orderId): JsonResponse
    {
        $order = $this->repository->findByIdOrFail($orderId);

        if (
            $order->status !== OrderStatusEnum::WAITING
            || $order->supplier_id !== request()->attributes->get('supplier_id')
        ) {
            return EmptyResource::make([
                'message' => __('The order is not in waiting status')
            ])->response()->setStatusCode(403);
        }

        $this->repository->deleteById($orderId);
        return EmptyResource::make([
            'message' => __('The order is deleted')
        ])->response()->setStatusCode(202);
    }
}
