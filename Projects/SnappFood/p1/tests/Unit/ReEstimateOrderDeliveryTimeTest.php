<?php

namespace Tests\Unit;

use App\Jobs\ReEstimateOrderDeliveryTime;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ReEstimateOrderDeliveryTimeTest extends TestCase
{
    public function test_update_order_delivery_time_when_webservice_returns_success_response()
    {
        $order = Order::factory()->create();
        $newDeliveryTime = fake()->numberBetween(10, 100);

        Http::fake([
            '*' => Http::response($newDeliveryTime, Response::HTTP_OK)
        ]);

        ReEstimateOrderDeliveryTime::dispatch($order);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'delivery_time' => $newDeliveryTime
        ]);
    }

    public function test_update_order_delivery_time_when_webservice_returns_unsuccessful_response()
    {
        $order = Order::factory()->create();
        $initialDeliveryTime = $order->delivery_time;

        Http::fake([
            '*' => Http::response([], Response::HTTP_NOT_FOUND)
        ]);

        ReEstimateOrderDeliveryTime::dispatch($order);

        $this->assertGreaterThan($initialDeliveryTime, $order->refresh()->delivery_time);
    }

    public function test_update_order_delivery_time_when_webservice_throws_exception()
    {
        $order = Order::factory()->create();
        $initialDeliveryTime = $order->delivery_time;

        Http::fake([
            '*' => Http::response([], Response::HTTP_INTERNAL_SERVER_ERROR)
        ]);

        ReEstimateOrderDeliveryTime::dispatch($order);

        $this->assertGreaterThan($initialDeliveryTime, $order->refresh()->delivery_time);
    }
}
