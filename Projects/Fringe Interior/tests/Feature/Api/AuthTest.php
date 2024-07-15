<?php

namespace Tests\Feature\Api;

use App\Models\Sanctum\PersonalAccessToken;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class AuthTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    public function testRegisterResponsesValidationErrorWhenRequestBodyIsInvalid(): void
    {
        $response = $this->postJson(route("api.register"), ["email" => "sdx", "password" => 123]);
        $response->assertUnprocessable();
    }

    public function testRegisterResponsesValidationErrorWhenEmailIsTakenByOtherUser(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route("api.register"), ["name" => $user->name, "email" => $user->email, $user->getAuthPassword()]);
        $response->assertUnprocessable();
    }

    public function testRegisterResponsesSuccess(): void
    {
        $response = $this->postJson(route("api.register"), ["name" => "test", "email" => "test@gmail.com", "password" => "password"]);
        $response->assertCreated();
    }

    public function testRegisterCreatesUserOnSuccess(): void
    {
        $this->assertDatabaseEmpty(User::class);
        $response = $this->postJson(route("api.register"), ["name" => "test", "email" => "test@gmail.com", "password" => "password"]);
        $response->assertCreated();
        $this->assertDatabaseCount(User::class, 1);
    }

    public function testRegisterCreatesAndReturnsTokenOnSuccess(): void
    {
        $response = $this->postJson(route("api.register"), ["name" => "test", "email" => "test@gmail.com", "password" => "password"]);

        $response->assertCreated()->assertJsonStructure(["status", "data" => ["token"], "message"]);
    }

    public function testLoginReturnsErrorWhenEmailOrPasswordIsInvalid(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route("api.login"), ["email" => $user->email, "password" => "invalidPassword"]);
        $response->assertBadRequest();

        $response = $this->postJson(route("api.login"), ["email" => "email@email.com","password" => "password"]);

        $response->assertBadRequest();

    }

    public function testLoginReturnsValidationErrorWhenRequestBodyIsInvalid(): void
    {
        $response = $this->postJson(route("api.login"), ["email" => $this->faker->word, "password" => $this->faker->password(2, 2)]);
        $response->assertUnprocessable();
    }

    public function testLoginResponsesSuccess(): void
    {
        $user = User::factory()->create();

        $response = $this->postJson(route("api.login")  , ["email" => $user->email, 'password' => UserFactory::PASSWORD]);

        $response->assertAccepted();
    }

    public function testLoginCreatesAndReturnsTokenWhenResponseIsSuccess(): void
    {
        $user = User::factory()->create();
        $response = $this->postJson(route("api.login"), ["email" => $user->email, 'password' => UserFactory::PASSWORD]);
        $response->assertAccepted()->assertJsonStructure(["status", "data" => ["token"], "message"]);
    }

    public function testLogoutResponsesAuthenticationError(): void
    {
        $response = $this->deleteJson(route("api.logout"));
        $response->assertUnauthorized();
    }

    public function testLogoutResponsesSuccess(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->deleteJson(route("api.logout"));
        $response->assertAccepted();
    }

    public function testLogoutDeletesUserToken(): void
    {
        $user = User::factory()->create();
        $this->assertDatabaseEmpty(PersonalAccessToken::class);
        $user->createToken("token")->plainTextToken;

        $this->assertDatabaseCount(PersonalAccessToken::class, 1);

        $response = $this->actingAs($user)->deleteJson(route("api.logout"));
        $response->assertAccepted();
        $this->assertDatabaseEmpty(PersonalAccessToken::class);
    }
}
