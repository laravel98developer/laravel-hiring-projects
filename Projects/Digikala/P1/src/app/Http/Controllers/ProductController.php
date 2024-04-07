<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProductRequest $productRequest
     * @return Response
     */
    public function index(ProductRequest $productRequest): Response
    {
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ProductCollection($this->productService->getAll($productRequest->validated()))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $productRequest
     * @return Response
     */
    public function store(ProductRequest $productRequest): Response
    {

        $result = $this->productService->addProduct($productRequest->validated());
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
     * @return Response
     */
    public function show(int $id): Response
    {
        $product = $this->productService->getProduct($id);
        return response()->success(
            __('messages.received_successfully'),
            Response::HTTP_OK,
            new ProductResource($product)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $productRequest
     * @param int $id
     * @return Response
     */
    public function update(ProductRequest $productRequest, int $id): Response
    {
        $this->productService->updateProduct($id, $productRequest->validated());
        return response()->success(
            __('messages.update_successfully'),
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        $this->productService->deleteProduct($id);
        return response()->success(
            __('messages.delete_successfully'),
            Response::HTTP_OK
        );
    }
}
