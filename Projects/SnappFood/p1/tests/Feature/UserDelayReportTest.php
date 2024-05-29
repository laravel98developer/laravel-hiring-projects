<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserDelayReportTest extends TestCase
{
    public function test_reporting_delay_for_an_order_with_unreviewed_delay_report(): void
    {
        /** @var Authenticatable $user */
        $user = User::query()->first();

        $order_delivery_time_before = Order::query()->find(1)->delivery_time;

        $response = $this
            ->actingAs($user)
            ->post(route('submit-delay-report', ['order' => 1]));

        $order_delivery_time_after = Order::query()->find(1)->delivery_time;

        $this->assertGreaterThan($order_delivery_time_before, $order_delivery_time_after);
        $response->assertStatus(Response::HTTP_ALREADY_REPORTED);
    }

    public function test_reporting_delay_for_an_order_without_unreviewed_delay_report(): void
    {
        /** @var Authenticatable $user */
        $user = User::query()->first();

        $order_delivery_time_before = Order::query()->find(2)->delivery_time;

        $response = $this
            ->actingAs($user)
            ->post(route('submit-delay-report', ['order' => 2]));

        $order_delivery_time_after = Order::query()->find(2)->delivery_time;

        $this->assertGreaterThan($order_delivery_time_before, $order_delivery_time_after);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_reporting_delay_for_an_order_without_trip(): void
    {
        /** @var Authenticatable $user */
        $user = User::query()->first();

        $order_delivery_time_before = Order::query()->find(5)->delivery_time;

        $this
            ->actingAs($user)
            ->post(route('submit-delay-report', ['order' => 5]));

        $order_delivery_time_after = Order::query()->find(5)->delivery_time;

        $this->assertEquals($order_delivery_time_before, $order_delivery_time_after);
    }

    public function test_reporting_delay_for_an_order_with_delivered_trip(): void
    {
        /** @var Authenticatable $user */
        $user = User::query()->first();

        $order_delivery_time_before = Order::query()->find(4)->delivery_time;

        $this
            ->actingAs($user)
            ->post(route('submit-delay-report', ['order' => 4]));

        $order_delivery_time_after = Order::query()->find(4)->delivery_time;

        $this->assertEquals($order_delivery_time_before, $order_delivery_time_after);
    }
}
