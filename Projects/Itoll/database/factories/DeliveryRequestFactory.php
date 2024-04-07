<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeliveryRequest>
 */
class DeliveryRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'origin_latitude' => 12.5,
            'origin_longitude' => 13,
            'origin_firstname' => 'Mohammad Javad',
            'origin_lastname' => 'Mehrabi',
            'origin_address' => 'Isfahan',
            'origin_phone' => '989336223710',
            'destination_latitude' => 22.3,
            'destination_longitude' => 53,
            'destination_firstname' => 'Reza',
            'destination_lastname' => 'Keramati',
            'destination_address' => 'Tehran',
            'destination_phone' => '989126223710',
            'collection_user_id' => 2,
        ];
    }
}
