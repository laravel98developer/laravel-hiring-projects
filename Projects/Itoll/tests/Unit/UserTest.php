<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @dataProvider provider_set_webhook
     * @return void
     */
    public function test_set_webhook($userid, $targetid, $url, $expected)
    {
        $user = User::findOrFail($userid);
        if($user->role !== Role::DELIVERER->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::USER_UPDATE->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        if($userid !== $targetid) { // consider we want to edit as an admin
            $route = "/$targetid";
        } else {
            $route = "";
        }
        $response = $this->putJson("api/users/setwebhook" . $route, ["url" => $url], ['Authorization' => 'Bearer ' . $token]);
        if($response->getStatusCode() == Response::HTTP_OK) {
            $newurl = User::find($targetid)->webhook_url;
            $this->assertEquals($url, $newurl);
        } else {
            $response->assertStatus($expected);
        }
    }

    public function provider_set_webhook()
    {
        yield ['userid' => 1, 'targetid' => 2, 'url' => "http://google.com", "expected" => Response::HTTP_OK];
        yield ['userid' => 1, 'targetid' => 2, 'url' =>  Str::random(2049), "expected" => Response::HTTP_UNPROCESSABLE_ENTITY];
        yield ['userid' => 2, 'targetid' => 2, 'url' => "http://google.com", "expected" => Response::HTTP_OK];
        yield ['userid' => 2, 'targetid' => 4, 'url' => "http://google.com", "expected" => Response::HTTP_FORBIDDEN]; // collection cannot change each other webhooks
        yield ['userid' => 1, 'targetid' => 3, 'url' => "http://google.com", "expected" => Response::HTTP_FORBIDDEN]; // cannot set webhook for deliverer
        yield ['userid' => 3, 'targetid' => 3, 'url' => "http://google.com", "expected" => Response::HTTP_FORBIDDEN]; // deliverer cannot change the webhook
    }


    /**
     * @return void
     */
    public function test_get_token()
    {
        $response = $this->getJson("api/users/get-token");
        $response->assertJsonStructure(["status", "data" => ["*" => ["user_id", "name", "role", "token"]]]);
    }
}
