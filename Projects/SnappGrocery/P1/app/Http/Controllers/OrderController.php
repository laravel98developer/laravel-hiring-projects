<?php

namespace App\Http\Controllers;

use App\Contracts\Services\OrderServiceInterface;
use App\Helpers\DtoHelper;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(protected OrderServiceInterface $orderService)
    {
    }

    public function store(OrderStoreRequest $request): JsonResource
    {
        $orderWithOrderProductShowDto = DB::transaction(function () use ($request) {
            $orderStoreDto = DtoHelper::requestTOrderStoreDto($request);
            return $this->orderService->store($orderStoreDto);
        });

        return OrderResource::make($orderWithOrderProductShowDto);
    }
}
