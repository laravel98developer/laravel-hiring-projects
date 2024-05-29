<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Agent;
use App\Models\DelayReport;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DelayReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DelayReport::factory()
            ->count(4)
            ->sequence(
                [
                    'order_id' => Order::query()->oldest()->first()->id,
                    'agent_id' => Agent::query()->oldest('id')->first()->id,
                    'reviewed_at' => now()->subDays(2)->addHour()->addMinutes(15),
                    'created_at' => now()->subDays(2)->addHour(),
                ],
                [
                    'order_id' => Order::query()->oldest()->first()->id,
                    'agent_id' => Agent::query()->latest('id')->first()->id,
                    'reviewed_at' => null,
                    'created_at' => now()->subDays(2)->addHours(2),
                ],
                [
                    'order_id' => Order::query()->latest()->skip(1)->first()->id,
                    'agent_id' => null,
                    'reviewed_at' => null,
                    'created_at' => now(),
                ],
                [
                    'order_id' => Order::query()->latest()->first()->id,
                    'agent_id' => null,
                    'reviewed_at' => null,
                    'created_at' => now(),
                ],
            )
            ->create();
    }
}
