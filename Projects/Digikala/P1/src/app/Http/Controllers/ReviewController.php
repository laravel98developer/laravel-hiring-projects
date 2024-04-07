<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ReviewCollection;
use App\Http\Resources\ReviewResource;
use App\Repositories\ProductReviewRepository;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ReviewController extends Controller
{

    private $reviewService;

    public function __construct(ReviewService $reviewService)
    {

        $this->middleware('product.is.reviewable', ['only' => ['store']]);
        $this->reviewService = $reviewService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ReviewRequest $reviewRequest
     * @return JsonResponse
     */
    public function index(ReviewRequest $reviewRequest): JsonResponse
    {
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ReviewCollection($this->reviewService->getAll($reviewRequest->validated()))
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
        $product = $this->reviewService->getReviewById($id);
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ReviewResource($product)
        );
    }

    /**
     * Store the specified resource in storage.
     *
     * @param ReviewRequest $reviewRequest
     * @return JsonResponse
     */
    public function store(ReviewRequest $reviewRequest): JsonResponse
    {
        $this->reviewService->createReview($reviewRequest->validated());
        return response()->success(
            __('messages.created'),
            Response::HTTP_OK
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReviewRequest $reviewRequest
     * @param int $id
     * @return Response
     */
    public function update(ReviewRequest $reviewRequest, int $id)
    {
        $this->reviewService->updateReview($id, $reviewRequest->validated());
        return response()->success(
            __('messages.update_successfully'),
            Response::HTTP_OK
        );
    }
}
