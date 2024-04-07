<?php

namespace App\Services;

use App\Repositories\BasketRepository;
use App\Repositories\ProductReviewRepository;

class ProductReviewService
{
    private $productReviewRepository;
    private $basketService;

    public function __construct(ProductReviewRepository $productReviewRepository, BasketService $basketService)
    {
        $this->productReviewRepository = $productReviewRepository;
        $this->basketService = $basketService;
    }

    public function getAll($productReviewData)
    {
        return $this->productReviewRepository->getAll($productReviewData);
    }

    public function getProductReviewByProductId($productId)
    {
        return $this->productReviewRepository->getByProductId($productId);
    }

    public function createProductReview($productReviewData)
    {
        return $this->productReviewRepository->create($productReviewData);
    }

    public function checkIsReviewable($product_id): bool
    {
        $product_review = $this->getProductReviewByProductId($product_id);

        if(!$product_review || !$product_review->is_reviewable){
            return false;
        }

        if($product_review->is_reviewable && !$product_review->only_user_that_bought_product){
            return true;
        }

        if($this->checkUserCanReview($product_review)){
            return true;
        }

        return false;
    }

    private function checkUserCanReview($product_review): bool
    {
        return Auth()->user() && $product_review->only_user_that_bought_product &&
            $this->basketService->checkUserBoughtProduct($product_review->product_id);
    }

}
