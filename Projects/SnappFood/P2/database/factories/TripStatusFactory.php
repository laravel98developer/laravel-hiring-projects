<?php

namespace Database\Factories;

use App\Enums\Tripe\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Symfony\Component\Uid\Ulid;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TripStatus>
 */
class TripStatusFactory extends Factory
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
            'status' => Arr::random(Status::VALUES),
            'created_at' => $createdTime,
        ];
    }
}
