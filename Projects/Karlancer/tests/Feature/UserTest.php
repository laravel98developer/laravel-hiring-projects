<?php

namespace Tests\Feature;

use Database\Factories\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testUserShowResponsesHttpUnauthorizedWhenUserIsGuest(): void
    {
        $response = $this->getJson(route('user.show'));
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserShowResponsesHttpOkWhenUserIsLoggedIn(): void
    {
        $user = UserFactory::new()->create();

        $response = $this->actingAs($user)->getJson(route('user.show'));
        $response->assertStatus(Response::HTTP_OK);
    }

}
