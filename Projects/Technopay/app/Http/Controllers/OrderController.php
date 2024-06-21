<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderFilterResource;
use App\services\OrderService\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrderController extends Controller
{
    public function __construct(public OrderService $orderService)
    {
    }

    public function filters(Request $request): AnonymousResourceCollection
    {
        $response = $this->orderService->filters($request->query());
        return OrderFilterResource::collection($response);
    }
}
