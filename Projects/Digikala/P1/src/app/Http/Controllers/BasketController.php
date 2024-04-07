<?php

namespace App\Http\Controllers;

use App\Http\Requests\BasketRequest;
use App\Http\Resources\BasketCollection;
use App\Http\Resources\BasketResource;
use App\Services\BasketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class BasketController extends Controller
{

    private $basketService;

    public function __construct(BasketService $basketService)
    {
        $this->basketService = $basketService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param BasketRequest $basketRequest
     * @return JsonResponse
     */
    public function index(BasketRequest $basketRequest): JsonResponse
    {
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new BasketCollection($this->basketService->getAll($basketRequest->validated()))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BasketRequest $basketRequest
     * @return JsonResponse
     */
    public function store(BasketRequest $basketRequest): JsonResponse
    {

        $result = $this->basketService->addBasket($basketRequest->validated());
        if(!$result){
            return response()->error(
                __('messages.error_in_created'),
                Response::HTTP_BAD_REQUEST
            );
        }
        return response()->success(
            __('messages.created'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $product = $this->basketService->getBasket($id);
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new BasketResource($product)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BasketRequest $basketRequest
     * @param int $id
     * @return JsonResponse
     */
    public function update(BasketRequest $basketRequest, int $id): JsonResponse
    {
        $this->basketService->updateBasket($id, $basketRequest->validated());
        return response()->success(
            __('messages.update_successfully'),
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->basketService->deleteBasket($id);
        return response()->success(
            __('messages.delete_successfully'),
            Response::HTTP_OK
        );
    }
}
