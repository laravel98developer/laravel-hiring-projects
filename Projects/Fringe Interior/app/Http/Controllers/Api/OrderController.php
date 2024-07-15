<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\OrderRequest;
use App\Repositories\Cache\CacheRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Services\OrderService;
use App\Utils\Response;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderController extends Controller
{
    private OrderRepositoryInterface $orderRepository;
    private OrderService $orderService;
    private CacheRepositoryInterface $cacheRepository;
    private const CACHE_TAG = "orders";

    public function __construct(OrderRepositoryInterface $orderRepository, CacheRepositoryInterface $cacheRepository, OrderService $orderService)
    {
        $this->orderRepository = $orderRepository;
        $this->orderService = $orderService;
        $this->cacheRepository = $cacheRepository;
    }

    public function index(Request $request)
    {
        $page = $request->get("page");

        $orders = $this->cacheRepository->getOrSet(self::CACHE_TAG, "all_orders_page_$page", function () {
            return $this->orderRepository->all();
        }, 120);


        if ($orders->isEmpty())
            throw new NotFoundHttpException();

        return Response::success($orders, "All Orders", HttpResponse::HTTP_OK);
    }

    public function store(OrderRequest $request)
    {
        return $this->orderService->storeOrder($request->validationData());
    }

    public function show(string $id)
    {
        $order = $this->cacheRepository->getOrSet(self::CACHE_TAG, "order_show_$id", function () use ($id) {
            $this->orderRepository->findById($id);
        }, 120);

        return Response::success($order, "Order Show", HttpResponse::HTTP_OK);
    }

    public function update(string $id, OrderRequest $request)
    {
        return $this->orderService->updateOrder($id, $request->validationData());
    }

    public function delete(string $id)
    {
        return $this->orderService->deleteOrder($id);
    }


}
