<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Services\EnquiryService;
use App\Services\ReviewService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private EnquiryService $enquiryService,
        private ReviewService $reviewService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productRepository->all([
            'status' => true,
        ]);

        $products = $this->enquiryService->getPrices($products);
        $products = $this->reviewService->getReviews($products);

        return response()->json(ProductResource::collection($products));
    }
}
