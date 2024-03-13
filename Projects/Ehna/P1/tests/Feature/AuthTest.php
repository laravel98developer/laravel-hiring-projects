<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanLogin(): void
    {
        $user = User::factory()->password()->create();

        $response = $this->post('api/login', [
            'username' => $user->username,
            'password' => 'secret',
            'device_name' => 'Testing Device',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);
    }

    public function testUserCanLogout(): void
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->post('api/logout');

        $response->assertOk();
    }
}
