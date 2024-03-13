<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function testNewUserCanRegister(): void
    {
        $response = $this->post('api/register', [
            'username' => 'testing_username',
            'password' => 'testing_password',
            'password_confirmation' => 'testing_password',
            'device_name' => 'Testing Device',
        ]);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'token'
            ]
        ]);

        $this->assertDatabaseHas(User::class, [
            'username' => 'testing_username',
        ]);
    }
}
