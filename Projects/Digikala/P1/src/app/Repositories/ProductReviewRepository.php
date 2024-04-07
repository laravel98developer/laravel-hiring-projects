<?php

namespace App\Repositories;

use App\Models\ProductReview;

class ProductReviewRepository
{
    private $model;

    public function __construct(ProductReview $productReview)
    {
        $this->model = $productReview;
    }

    public function getAll($showDataOptions)
    {
        $productReviews = $this->model->query();
        $sort_column = $showDataOptions['sort_column'] ?? 'created_at';
        $productReviews->orderBy($sort_column, isset($showDataOptions['is_sort_dir_desc']) && $showDataOptions['is_sort_dir_desc']=='true' ? 'desc' : 'asc');

        return $productReviews->paginate($showDataOptions['per_page'] ?? 10);
    }

    public function getByProductId($productId)
    {
        return $this->model->where('product_id', $productId)
            ->with(['reviews'=>function($query) {
                return $query->where('status', 1)
                    ->orderBy('created_at', 'desc')
                    ->limit(env('show_review_count', 3));
            }])->firstOrFail();
    }

    public function create($productReviewData)
    {
        return $this->model->updateOrCreate(
            ['product_id' => $productReviewData['product_id']],
            $productReviewData
        );
    }

    public function updateProductReviewByProductId($product_id, $review_aggregate)
    {
        return ProductReview::where('product_id', $product_id)->update(
            [
                'vote_avg' => $review_aggregate['avg'] ?? 0,
                'review_count' => $review_aggregate['count'] ?? 0,
            ]
        );
    }


}
