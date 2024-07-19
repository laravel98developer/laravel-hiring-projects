<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BankAccount>
 */
class BankAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_number' => fake()->unique()->numberBetween(1_000_000_000, 9_999_999_999),
            'balance' => fake()->numberBetween(1_000, 100_000_000),
        ];
    }
}
