<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductReviewRequest;
use App\Http\Resources\ProductReviewCollection;
use App\Http\Resources\ProductReviewResource;
use App\Services\ProductReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductReviewController extends Controller
{

    private $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductReviewRequest $productReviewRequest
     * @return JsonResponse
     */
    public function index(ProductReviewRequest $productReviewRequest): JsonResponse
    {
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ProductReviewCollection($this->productReviewService->getAll($productReviewRequest->validated()))
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
        $product = $this->productReviewService->getProductReviewByProductId($id);
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ProductReviewResource($product)
        );
    }

    /**
     * Store the specified resource in storage.
     *
     * @param ProductReviewRequest $productReviewRequest
     * @return JsonResponse
     */
    public function store(ProductReviewRequest $productReviewRequest): JsonResponse
    {
        $this->productReviewService->createProductReview($productReviewRequest->validated());
        return response()->success(
            __('messages.update_successfully'),
            Response::HTTP_OK
        );
    }
}
