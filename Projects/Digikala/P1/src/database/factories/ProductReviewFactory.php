<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $products = Product::all();
        return [
            'is_reviewable' => $this->faker->boolean(),
            'only_user_that_bought_product' => $this->faker->boolean(),
            'product_id' => $this->faker->unique()->numberBetween(1, $products->count()),
            'vote_avg' => 0,
            'review_count' => 0
         ];
    }
}
