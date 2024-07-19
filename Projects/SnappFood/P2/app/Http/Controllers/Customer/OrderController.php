<?php

namespace App\Http\Controllers\Customer;

use App\Contracts\Repository\OrderRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\OrderStoreRequest;
use App\Http\Resources\Customer\OrderCollection;
use App\Http\Resources\Customer\OrderResource;
use App\Service\MockDelay\GetMockDelayTimeRequest;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepository
    )
    {
    }

    public function store(OrderStoreRequest $request): OrderResource
    {
        $data = $request->validated();
        $data['delivery_time'] = GetMockDelayTimeRequest::build()->send()->json('data.delay_time');

        return OrderResource::make(
            $this->orderRepository->create($data)
        );
    }

    public function index(): OrderCollection
    {
        return OrderCollection::make(
            $this->orderRepository->all()
        );
    }
}
