<?php

namespace Tests\Feature\Api;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use DatabaseMigrations;

    public function testOrdersIndexResponsesAuthenticationError(): void
    {
        $response = $this->getJson(route("api.orders_index"));
        $response->assertUnauthorized();
    }

    public function testOrdersIndexResponsesNotFoundError(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route("api.orders_index"));
        $response->assertNotFound();
    }

    public function testOrdersIndexResponsesSuccess(): void
    {
        Order::factory()->has(Product::factory())->create();
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route("api.orders_index"));
        $response->assertOk();
    }

    public function testOrdersStoreResponsesAuthenticationError(): void
    {
        $response = $this->postJson(route("api.orders_store"));
        $response->assertUnauthorized();
    }

    public function testOrderStoreResponsesValidationError(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route("api.orders_store"), ["products" => [
            "pr",
            "pi"
        ]]);
        $response->assertUnprocessable();
    }

    public function testOrderStoreResponsesNotFoundWhenAnProductNotFounded(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post(route("api.orders_store"), ["products" => [
            "id" => "fakeId",
            "quantity" => 123
        ]]);
        $response->assertUnprocessable();
    }

    public function testOrderStoreResponsesBadRequestWhenAProductInventoryGoesLessThanZero(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson(route("api.orders_store"), [
            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => $product->inventory + 1
                ]
            ]
        ]);
        $response->assertBadRequest();
    }

    public function testOrderStoreResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->postJson(route("api.orders_store"), [
            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => $product->inventory
                ]
            ]
        ]);
        $response->assertCreated();
    }

    public function testOrderStoreUpdatesProductInventory(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $quantity = 5;
        $inventory = $product->inventory;

        $response = $this->actingAs($user)->postJson(route("api.orders_store"), [
            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => $quantity
                ]
            ]
        ]);

        $response->assertCreated();

        $product = Product::find($product->id);

        $this->assertEquals($inventory - $quantity, $product->inventory);
    }

    public function testOrderShowResponsesAuthenticationError(): void
    {
        $order = Order::factory()->has(Product::factory())->create();

        $response = $this->getJson(route("api.orders_show", ["id" => $order->id]));
        $response->assertUnauthorized();
    }

    public function testOrderShowResponsesNotFoundError(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route("api.orders_show", ["id" => "1"]));
        $response->assertNotFound();
    }

    public function testOrderShowResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->has(Product::factory())->create();


        $response = $this->actingAs($user)->getJson(route("api.orders_show", ["id" => $order->id]));
        $response->assertOk();
    }

    public function testOrderUpdateResponsesAuthenticationError(): void
    {
        $order = Order::factory()->has(Product::factory()->count(10))->create();

        $response = $this->putJson(route("api.orders_update", ["id" => $order]));
        $response->assertUnauthorized();
    }

    public function testOrderUpdateResponsesNotFoundError(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route("api.orders_update", ["id" => "1"]), [
            "products" => [
                [
                    "id" => "fakeId",
                    "quantity" => 1000
                ]
            ]
        ]);
        $response->assertNotFound();
    }

    public function testOrderUpdateResponsesValidationErrorOnInvalidRequestBody(): void
    {
        $user = User::factory()->create();
        $order = Order::factory()->has(Product::factory()->count(10))->create();
        $response = $this->actingAs($user)->putJson(route("api.orders_update", ["id" => $order->id], [
            "products" => [
                [
                    "id" => "k",
                    "quantity" => 0
                ]
            ]
        ]));

        $response->assertUnprocessable();
    }

    public function testOrderUpdateResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $order = Order::factory()->create();

        $order->products()->associate($product)->save();

        $response = $this->actingAs($user)->putJson(route("api.orders_update", ["id" => $order->id]), [
            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => $product->inventory - 2
                ]
            ]
        ]);

        $response->assertAccepted();
    }

    public function testOrderUpdateUpdatesInventoryOfProduct(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->set("inventory", 50)->create();
        $order = Order::factory()->create();

        $product->quantity = 30;

        $order->products()->associate($product)->save();

        $updateQuantity = 20;

        $expectedProductInventory = $product->inventory + 10;

        $response = $this->actingAs($user)->putJson(route("api.orders_update", ["id" => $order->id]), [
            "products" => [
                [
                    "id" => $product->id,
                    "quantity" => $updateQuantity
                ]
            ]
        ]);

        $response->assertAccepted();

        $product = Product::find($product->id);

        $this->assertEquals($expectedProductInventory, $product->inventory);

    }


    public function testOrderDeleteResponsesAuthenticationError(): void
    {
        $product = Product::factory()->create();

        $response = $this->deleteJson(route("api.orders_delete", ["id" => $product->id]));
        $response->assertUnauthorized();
    }

    public function testOrderDeleteResponsesNotFound(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->deleteJson(route("api.orders_delete", ["id" => "fakeId"]));
        $response->assertNotFound();
    }

    public function testOrderDeleteResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();
        $order = Order::factory()->create();
        $order->products()->associate($product)->save();

        $response = $this->actingAs($user)->deleteJson(route("api.orders_delete", ["id" => $order->id]));
        $response->assertAccepted();
    }

    public function testOrderDeleteUpdatesInventoryOfProduct(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->set("inventory", 50)->create();
        $order = Order::factory()->create();

        $product->quantity = 50;
        $expectedInventoryAfterDelete = 100;

        $order->products()->associate($product)->save();

        $response = $this->actingAs($user)->deleteJson(route("api.orders_delete", ["id" => $order->id]));
        $response->assertAccepted();
        $product = Product::find($product->id);
        $this->assertEquals($expectedInventoryAfterDelete, $product->inventory);
    }
}
