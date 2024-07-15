<?php

namespace Tests\Feature\Api;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use DatabaseMigrations;
    public function testProductsIndexResponsesAuthenticationError(): void
    {
        $response = $this->getJson(route("api.products_index"));
        $response->assertUnauthorized();
    }

    public function testProductsIndexResponsesNotFoundErrorWhenNoProductIsInDatabase(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route("api.products_index"));
        $response->assertNotFound();
    }

    public function testProductsIndexResponsesSuccess(): void
    {
        $user = User::factory()->create();
        Product::factory()->count(10)->create();
        $response = $this->actingAs($user)->getJson(route("api.products_index"));
        $response->assertOk();
    }

    public function testProductsStoreResponsesAuthenticationError(): void
    {
        $response = $this->postJson(route("api.products_store"));
        $response->assertUnauthorized();
    }

    public function testProductsStoreResponsesValidationErrorWhenRequestBodyIsInvalid(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route("api.products_store"), ["name" => 'a', "price" => 0, "inventory" => 0.2]);
        $response->assertUnprocessable()->assertJsonStructure(["status", "data" => ["errors" => "inventory", "name", "price"], "message"]);
    }

    public function testProductsStoreResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route("api.products_store"), ["name" => "someProduct", "price" => 1000.4, "inventory" => 10]);

        $response->assertCreated();
    }

    public function testProductsShowResponsesAuthenticationError(): void
    {
        $product = Product::factory()->create();
        $response = $this->getJson(route("api.products_show", ["id" => $product->id]));
        $response->assertUnauthorized();
    }

    public function testProductsShowResponsesNotFound(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route("api.products_show", ["id" => 1]));
        $response->assertNotFound();
    }

    public function testProductsShowResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->getJson(route("api.products_show", ["id" => $product->id]));
        $response->assertOk();
    }

    public function testProductsUpdateResponsesAuthenticationError(): void
    {
        $product = Product::factory()->create();

        $response = $this->putJson(route("api.products_update", ["id" => $product->id]));
        $response->assertUnauthorized();
    }

    public function testProductsUpdateResponsesNotFound(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route("api.products_update", ["id" => 1]), ["name" => "newName", "price" => 1000, "inventory" => 1]);

        $response->assertNotFound();
    }

    public function testProductsUpdateResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->putJson(route("api.products_update", ["id" => $product->id]), ["name" => "newName", "price" => 1000, "inventory" => 0]);
        $response->assertAccepted();
    }

    public function testProductsDeleteResponsesAuthenticationError(): void
    {
        $product = Product::factory()->create();
        $response = $this->deleteJson(route("api.products_delete", ["id" => $product->id]));
        $response->assertUnauthorized();
    }

    public function testProductsDeleteResponsesNotFound(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->deleteJson(route("api.products_delete", ["id" => 1]));
        $response->assertNotFound();
    }

    public function testProductsDeleteResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->deleteJson(route("api.products_delete", ["id" => $product->id], ["name" => "newName", "price" => 1000, "inventory" => 0]));
        $response->assertAccepted();
    }
}
