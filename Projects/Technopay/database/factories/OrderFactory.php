<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'mobile_number' => "0912" . rand(1111111, 9999999),
            'national_code' => "037576" . rand(1111, 9999),
            'amount'        => rand(111, 999) * 1000,
            'status'        => rand(0, 1),
        ];
    }
}
