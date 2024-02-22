<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\Provider;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid'                     => $this->faker->uuid,
            'provider_id'              => Provider::factory()->create()->id,
            'name'                     => $this->faker->name,
            'quantity'                 => $this->faker->numberBetween(1, 10),
            'status'                   => $this->faker->boolean,
            'comment_status'           => $this->faker->boolean,
            'comment_status_after_buy' => $this->faker->boolean,
            'vote_status'              => $this->faker->boolean,
            'vote_status_after_buy'    => $this->faker->boolean,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $this->createPrice($product);
            $this->createComments($product);
            $this->createVotes($product);
        });
    }

    private function createPrice(Product $product)
    {
        $product->prices()->create([
            'uuid'  => $this->faker->uuid,
            'price' => $this->faker->numberBetween(1000, 100000),
        ]);
    }

    private function createComments(Product $product)
    {
        collect(range(0, mt_rand(1, 10)))->each(function () use ($product) {
            $product->comments()->create([
                'uuid'       => $this->faker->uuid,
                'user_id'    => User::factory()->create()->id,
                'product_id' => $product->id,
                'content'    => $this->faker->text,
                'confirmed'  => $this->faker->boolean,
            ]);
        });
    }

    private function createVotes(Product $product)
    {
        collect(range(0, mt_rand(1, 10)))->each(function () use ($product) {
            $product->votes()->create([
                'uuid'       => $this->faker->uuid,
                'user_id'    => User::factory()->create()->id,
                'product_id' => $product->id,
                'rate'       => $this->faker->numberBetween(1, 5),
                'confirmed'  => $this->faker->boolean,
            ]);
        });
    }
}
