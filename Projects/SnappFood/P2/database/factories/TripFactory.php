<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Uid\Ulid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trip>
 */
class TripFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdTime = Carbon::now();

        return [
            'id' => Ulid::generate($createdTime),
            'created_at' => $createdTime,
            'updated_at' => $createdTime,
        ];
    }
}
