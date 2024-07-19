<?php

namespace Database\Factories;

use App\Models\Card;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'source_card_id' => Card::factory(),
            'destination_card_id' => Card::factory(),
            'amount' => $this->faker->numberBetween(1000, 10_000),
        ];
    }
}
