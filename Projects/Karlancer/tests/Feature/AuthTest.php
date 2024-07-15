<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function testRegisterResponsesHttpUnprocessableEntityWhenEmailAlreadyTaken(): void
    {
        $email = "example@gmail.com";
        $password = "password";

        User::factory()->create(["email" => $email, "password" => $password]);

        $response = $this->postJson(route("auth.register"), ["email" => $email, "password" => $password]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testRegisterResponsesHttpUnprocessableEntityWhenPasswordIsShort(): void
    {
        $email = "example@gmail.com";
        $password = "1";

        $response = $this->postJson(route("auth.register"), ["email" => $email, "password" => $password]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testRegisterResponsesHttpUnprocessableEntityWhenEmailIsNotValid(): void
    {
        $email = "example";
        $password = "password";

        $response = $this->postJson(route("auth.register"), ["email" => $email, "password" => $password]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testRegisterResponsesHttpCreatedWhenEmailAndPasswordIsValid(): void
    {
        $email = "example@gmail.com";
        $password = "password";

        $response = $this->postJson(route("auth.register"), ["email" => $email, "password" => $password]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testLoginResponsesHttpUnprocessableEntityWhenPasswordIsShort(): void
    {
        $email = "example@gmail.com";
        $password = "1";

        $response = $this->postJson(route("auth.login"), ["email" => $email, "password" => $password]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testLoginResponsesHttpUnprocessableEntityWhenEmailIsNotValid(): void
    {
        $email = "email";
        $password = "password";

        $response = $this->postJson(route("auth.login"), ["email" => $email, "password" => $password]);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testLoginResponsesHttpBadRequestWhenPasswordIsNotValid(): void
    {
        $email = "example@gmail.com";
        $password = "password";

        User::factory()->create([
            "email" => $email,
            "password" => $password
        ]);

        $response = $this->postJson(route("auth.login"), ["email" => $email, "password" => "invalidPassword"]);
        $response->assertStatus(Response::HTTP_BAD_REQUEST);
    }

    public function testLoginResponsesHttpOkWhenEmailAndPasswordIsValid(): void
    {
        $email = "example@gmail.com";
        $password = "password";

        User::factory()->create([
            "email" => $email,
            "password" => $password,
        ]);

        $response = $this->postJson(route("auth.login"), ["email" => $email, "password" => $password]);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function testLogoutResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $response = $this->deleteJson(route("auth.logout"));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testLogoutResponsesHttpAcceptedWhenUserIsLoggedIn(): void
    {
        $user = UserFactory::new()->create();
        $token = $user->createToken('token')->plainTextToken;
        $response = $this->deleteJson(route("auth.logout"), headers: ["Authorization" => "Bearer $token"]);
        $response->assertStatus(Response::HTTP_ACCEPTED);
    }
}
