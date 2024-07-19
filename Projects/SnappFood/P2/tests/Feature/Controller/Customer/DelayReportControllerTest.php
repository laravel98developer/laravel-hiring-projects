<?php

namespace Tests\Feature\Controller\Customer;

use App\Enums\DeliveryReport\Status;
use App\Models\DelayReport;
use App\Models\DelayReportStatus;
use App\Models\Order;
use App\Models\Trip;
use App\Models\TripStatus;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class DelayReportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refreshDatabase();
    }

    public function testStoreWhenOrderDoesNotHaveDelay()
    {
        Vendor::factory()
            ->has(
                Order::factory()
                    ->count(1)
                    ->state([
                        'delivery_time' => now()->addMinutes(50),
                    ])
            )
            ->count(1)
            ->create();

        $order = Order::query()->first();

        $this->post(
            route('customers.delay-reports.store'), [
                'order_id' => $order->id,
            ]
        )
            ->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => [
                    'detail' => 'order does not have delay',
                ],
            ]);

        $this->assertDatabaseCount('delay_report_statuses', 0);
    }

    public function testStoreWithoutTripe()
    {
        Vendor::factory()
            ->has(
                Order::factory()
                    ->count(1)
                    ->state([
                        'delivery_time' => now()->subMinutes(50),
                    ])
            )
            ->count(1)
            ->create();

        $order = Order::query()->first();

        $this->post(
            route('customers.delay-reports.store'), [
                'order_id' => $order->id,
            ]
        )
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    'current_status' => Status::CREATED,
                ],
            ]);

        $this->assertDatabaseCount('delay_report_statuses', 1);
    }

    public function testStoreWithDeliveredTripe()
    {
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
                    ])
            )
            ->count(1)
            ->create();

        $order = Order::query()->first();

        $this->post(
            route('customers.delay-reports.store'), [
                'order_id' => $order->id,
            ]
        )
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    'current_status' => Status::CREATED,
                ],
            ]);

        $this->assertDatabaseCount('delay_report_statuses', 1);
    }

    public function testStoreAssignedWithTripe()
    {
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
                    ])
                    ->count(1)
            )
            ->count(1)
            ->create();

        $order = Order::query()->first();

        $this->post(
            route('customers.delay-reports.store'), [
                'order_id' => $order->id,
            ]
        )
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJson([
                'data' => [
                    'current_status' => Status::COMPLETED,
                ],
            ]);

        $this->assertDatabaseCount('delay_report_statuses', 2);
    }

    public function testStoreWhenOrderHasActiveDelayReport()
    {
        Vendor::factory()
            ->has(
                Order::factory()
                    ->has(
                        DelayReport::factory()
                            ->has(
                                DelayReportStatus::factory()
                                    ->state([
                                        'status' => \App\Enums\DeliveryReport\Status::CREATED,
                                    ])
                                    ->count(1)
                            )
                            ->count(1)
                    )
                    ->state([
                        'delivery_time' => now()->subMinutes(50),
                    ])
                    ->count(1)
            )
            ->count(1)
            ->create();

        $order = Order::query()->first();

        $this->post(
            route('customers.delay-reports.store'), [
                'order_id' => $order->id,
            ]
        )->assertStatus(Response::HTTP_BAD_REQUEST)
            ->assertJson([
                'errors' => [
                    'detail' => 'order has delay report',
                ],
            ]);

    }
}
