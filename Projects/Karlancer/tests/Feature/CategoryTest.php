<?php

namespace Tests\Feature;

use App\Models\Category;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCategoryIndexResponsesAuthorizationErrorWhenUserIsGuest(): void
    {
        Category::factory()->createMany(10);
        $response = $this->getJson(route("category.index"));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testCategoryIndexResponsesHttpOkWhenUserIsLoggedIn(): void
    {
        Category::factory()->createMany(10);
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->getJson(route("category.index"));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testCategoryIndexResponsesHttpNotFoundWhenThereIsNoCategoryInDatabase(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->getJson(route("category.index"));
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
