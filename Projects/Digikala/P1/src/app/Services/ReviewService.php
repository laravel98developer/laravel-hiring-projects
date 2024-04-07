<?php

namespace App\Services;

use App\Repositories\ReviewRepository;

class ReviewService
{
    private $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function getAll($reviewData)
    {
        return $this->reviewRepository->getAll($reviewData);
    }

    public function getReviewById($reviewId)
    {
        return $this->reviewRepository->getById($reviewId);
    }

    public function createReview($reviewData)
    {
        return $this->reviewRepository->create($reviewData);
    }

    public function updateReview($reviewId, $reviewData)
    {
        return $this->reviewRepository->update($reviewId, $reviewData);
    }
}
