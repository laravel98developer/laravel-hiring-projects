<?php

namespace App\Repositories;

use App\Models\ProductReview;
use App\Models\Review;
use DB;

class ReviewRepository
{
    private $model;
    private $productReviewRepository;

    public function __construct(Review $review, ProductReviewRepository $productReviewRepository)
    {
        $this->model = $review;
        $this->productReviewRepository = $productReviewRepository;
    }

    public function getAll($showDataOptions)
    {
        $reviews = $this->model->query();
        if (isset($showDataOptions['product_id'])) {
            $reviews->where('product_id', $showDataOptions['product_id']);
        }
        if (isset($showDataOptions['status'])) {
            $reviews->where('status', $showDataOptions['status']);
        }
        $sort_column = $showDataOptions['sort_column'] ?? 'created_at';
        $reviews->orderBy($sort_column, isset($showDataOptions['is_sort_dir_desc']) && $showDataOptions['is_sort_dir_desc']=='true' ? 'desc' : 'asc');

        return $reviews->paginate($showDataOptions['per_page'] ?? 10);
    }

    public function create($reviewData)
    {
        if(auth()->check()){
            $reviewData['user_id'] = auth()->user()->id;
        }
        return $this->model->create($reviewData);
    }

    public function getById($reviewId)
    {
        return $this->model->findOrFail($reviewId);
    }

    public function update($reviewId, $reviewData)
    {
        $review = $this->getById($reviewId);
        DB::beginTransaction();
        $review->update(['status'=> $reviewData['status']]);

        $product_review_updated = $this->product_review_update($review->product_id);

        if (!$product_review_updated)
        {
            DB::rollback();
        }
        DB::commit();
        return $product_review_updated;
    }

    private function product_review_update($product_id)
    {
        $review_aggregation_data =  $this->model->where('product_id', $product_id)
            ->where('status', 1)->selectRaw('AVG(vote) as avg, COUNT(*) as count')->first();

        return $this->productReviewRepository->updateProductReviewByProductId(
            $product_id, $review_aggregation_data
        );

    }

}
