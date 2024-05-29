<?php

namespace Database\Seeders;

use App\Enums\TripStatus;
use App\Models\Order;
use App\Models\Trip;
use App\Models\User;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->count(4)
            ->has(Trip::factory()->sequence(
                ['status' => TripStatus::ASSIGNED],
                ['status' => TripStatus::AT_VENDOR],
                ['status' => TripStatus::PICKED],
                ['status' => TripStatus::DELIVERED],
            ))
            ->sequence(
                ['created_at' => now()->subDays(3)],
                ['created_at' => now()->subDays(2)],
                ['created_at' => now()->subDay()],
                ['created_at' => now()],
            )
            ->create();

        Order::factory()
            ->count(1)
            ->sequence(
                ['created_at' => now()->addHour()],
            )
            ->create();
    }
}
