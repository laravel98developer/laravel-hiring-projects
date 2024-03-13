<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_for_login_displays_the_login_form()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    public function test_for_login_displays_validation_errors()
    {
        $response = $this->post('/login', []);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function test_for_login_authenticates_and_redirects_user()
    {
        $user = User::find(1);
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'admin'
        ]);
        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_for_redirect_to_payment_page()
    {
        $user       = User::find(1);
        $card_number = $user->BankInfo->card_number;
        $response = $this->actingAs($user)->post(route('order.create'),['product_id'=>1,'card_number'=>$card_number]);
        $response->assertRedirectContains('https://core.paystar.ir/api/pardakht/payment');
    }

}
