<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'       => $this->faker->uuid,
            'user_id'    => User::factory()->create()->id,
            'product_id' => Product::factory()->create()->id,
            'content'    => $this->faker->text,
            'confirmed'  => $this->faker->boolean,
        ];
    }
}
