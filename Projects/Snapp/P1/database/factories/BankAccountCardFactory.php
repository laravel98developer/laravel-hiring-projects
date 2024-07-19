<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CardNumber>
 */
class BankAccountCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'unique_id' => fake()->uuid(),
            'card_number' => fake()->unique()->numberBetween(1_000_000_000_000_000, 9_999_999_999_999_999),
        ];
    }
}
