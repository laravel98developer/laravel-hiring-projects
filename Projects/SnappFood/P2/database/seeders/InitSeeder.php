<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Order;
use App\Models\Trip;
use App\Models\TripStatus;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $config = config('seed_config');

        // create order without delay
        if ($this->checkOrderDoesNotExist($config['create_order_without_delay_order_id'])) {
            Vendor::factory()
                ->has(
                    Order::factory()
                        ->count(1)
                        ->state([
                            'delivery_time' => now()->addMinutes(50),
                            'id' => $config['create_order_without_delay_order_id'],
                        ])
                )
                ->count(1)
                ->create();
        }


        // create order without tripe
        if ($this->checkOrderDoesNotExist($config['create_order_without_tripe_order_id'])) {
            Vendor::factory()
                ->has(
                    Order::factory()
                        ->count(1)
                        ->state([
                            'delivery_time' => now()->subMinutes(50),
                            'id' => $config['create_order_without_tripe_order_id'],
                        ])
                )
                ->count(1)
                ->create();
        }

        // create order with delivered tripe
        if ($this->checkOrderDoesNotExist($config['create_order_with_delivered_tripe_order_id'])) {
            Vendor::factory()
                ->has(
                    Order::factory()
                        ->has(
                            Trip::factory()
                                ->has(
                                    TripStatus::factory()
                                        ->state([
                                            'status' => \App\Enums\Tripe\Status::DELIVERED,
                                        ])
                                        ->count(1)
                                )
                                ->count(1)
                        )
                        ->count(1)
                        ->state([
                            'delivery_time' => now()->subMinutes(50),
                            'id' => $config['create_order_with_delivered_tripe_order_id'],
                        ])
                )
                ->count(1)
                ->create();
        }

        // create order with assigned tripe
        if ($this->checkOrderDoesNotExist($config['create_order_with_assigned_tripe_order_id'])) {
            Vendor::factory()
                ->has(
                    Order::factory()
                        ->has(
                            Trip::factory()
                                ->has(
                                    TripStatus::factory()
                                        ->state([
                                            'status' => \App\Enums\Tripe\Status::ASSIGNED,
                                        ])
                                        ->count(1)
                                )
                                ->count(1)
                        )
                        ->state([
                            'delivery_time' => now()->subMinutes(50),
                            'id' => $config['create_order_with_assigned_tripe_order_id'],
                        ])
                        ->count(1)
                )
                ->count(1)
                ->create();
        }

        // create agents

        if ($this->checkAgentDoesNotExist($config['create_agent_1_agent_id'])) {
            Agent::factory()
                ->state([
                    'id' => $config['create_agent_1_agent_id'],
                ])
                ->create();
        }

        if ($this->checkAgentDoesNotExist($config['create_agent_2_agent_id'])) {
            Agent::factory()
                ->state([
                    'id' => $config['create_agent_2_agent_id'],
                ])
                ->create();
        }
    }

    public function checkOrderDoesNotExist(string $orderId): bool
    {
        return Order::query()->where('id', $orderId)->doesntExist();
    }

    public function checkAgentDoesNotExist(string $agentId): bool
    {
        return Agent::query()->where('id', $agentId)->doesntExist();
    }
}
