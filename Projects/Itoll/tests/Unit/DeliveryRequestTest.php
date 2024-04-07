<?php

namespace Tests\Unit;

use App\Enums\Permission;
use App\Enums\Role;
use App\Models\DeliveryRequest;
use App\Models\User;
use App\Notifications\DelivererChangeStatus;
use Database\Seeders\DeliveryRequestAcceptedSeeder;
use Database\Seeders\DeliveryRequestReceivedSeeder;
use Database\Seeders\DeliveryRequestSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class DeliveryRequestTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;

    /**
     * @dataProvider provider_add_request
     * @return void
     */
    public function test_add_request($userid, $o_latitude, $o_longitude, $o_firstname, $o_lastname, $o_address, $o_phone, $d_latitude, $d_longitude, $d_firstname, $d_lastname, $d_address, $d_phone, $expected)
    {
        $user =  User::findOrFail($userid);
        if($user->role === Role::COLLECTION->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_INSERT->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        $count = DeliveryRequest::count();
        $response = $this->postJson('/api/delivery-request', compact('o_latitude', 'o_longitude', 'o_firstname', 'o_lastname', 'o_address', 'o_phone', 'd_latitude', 'd_longitude', 'd_firstname', 'd_lastname', 'd_address', 'd_phone'), ['Authorization' => 'Bearer ' . $token]);
        $this->assertDatabaseCount('delivery_requests', $count + $expected);
    }
    public function provider_add_request()
    {
        yield ['userid' => 2, 'origin_latitude' => 12.5, 'origin_longitude' => 13, 'origin_firstname' => 'Mohammad Javad', 'origin_lastname' => 'Mehrabi', 'origin_address' => 'Isfahan', 'origin_phone' => '989336223710', 'destination_latitude' => 22.3, 'destination_longitude' => 53, 'destination_firstname' => 'Reza', 'destination_lastname' => 'Keramati', 'destination_address' => 'Tehran', 'destination_phone' => '989126223710', 'expected' => 1];
        yield ['userid' => 2, 'origin_latitude' => 12.5, 'origin_longitude' => 13, 'origin_firstname' => 'Mohammad Javad', 'origin_lastname' => 'Mehrabi', 'origin_address' => 'Isfahan', 'origin_phone' => '989336223710', 'destination_latitude' => 22.3, 'destination_longitude' => 53, 'destination_firstname' => 'Reza', 'destination_lastname' => 'Keramati', 'destination_address' => 'Tehran', 'destination_phone' => '989126223710', 'expected' => 1];
        yield ['userid' => 2, 'origin_latitude' => 12.5, 'origin_longitude' => 13, 'origin_firstname' => 'Mohammad Javad', 'origin_lastname' => 'Mehrabi', 'origin_address' => 'Isfahan', 'origin_phone' => '989336223710', 'destination_latitude' => 22.3, 'destination_longitude' => 53, 'destination_firstname' => 'Reza', 'destination_lastname' => 'Keramati', 'destination_address' => 'Tehran', 'destination_phone' => '9989126223710', 'expected' => 0];
        yield ['userid' => 3, 'origin_latitude' => 12.5, 'origin_longitude' => 13, 'origin_firstname' => 'Mohammad Javad', 'origin_lastname' => 'Mehrabi', 'origin_address' => 'Isfahan', 'origin_phone' => '989336223710', 'destination_latitude' => 22.3, 'destination_longitude' => 53, 'destination_firstname' => 'Reza', 'destination_lastname' => 'Keramati', 'destination_address' => 'Tehran', 'destination_phone' => '989126223710', 'expected' => 0];
        yield ['userid' => 1, 'origin_latitude' => 12.5, 'origin_longitude' => 13, 'origin_firstname' => 'Mohammad Javad', 'origin_lastname' => 'Mehrabi', 'origin_address' => 'Isfahan', 'origin_phone' => '989336223710', 'destination_latitude' => 22.3, 'destination_longitude' => 53, 'destination_firstname' => 'Reza', 'destination_lastname' => 'Keramati', 'destination_address' => 'Tehran', 'destination_phone' => '989126223710', 'expected' => 0];
    }

    /**
     * @dataProvider provider_cancel_request
     * @return void
     */
    public function test_cancel_request($userid, $already_received, $expected)
    {
        DeliveryRequest::factory(1)->sequence(
            ['collection_user_id' => 2, "received_at" => ($already_received ? now() : null)]
        )->create();

        $id = DeliveryRequest::first()->id;
        $user =  User::findOrFail($userid);
        if($user->role === Role::COLLECTION->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_INSERT->value, Permission::DELIVERY_REQUEST_CANCEL->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        // first we will add a request by specified user id, because we want to cancel it, only if it was the same collection (other collections cannot cancel each other delivery requests)
        $response = $this->putJson("/api/delivery-request/$id/cancel", [], ['Authorization' => 'Bearer ' . $token]);
        if($response->getStatusCode() == Response::HTTP_OK) {
            $deliveryRequest = DeliveryRequest::findOrFail($id);
            $this->assertNotNull($deliveryRequest->canceled_at);
        } else {
            $response->assertStatus($expected);
        }
    }
    public function provider_cancel_request()
    {
        yield ['userid' => 2, 'already_received' => false, 'expected' => Response::HTTP_OK];
        yield ['userid' => 3, 'already_received' => false, 'expected' => Response::HTTP_FORBIDDEN]; // deliverer
        yield ['userid' => 1, 'already_received' => false, 'expected' => Response::HTTP_FORBIDDEN]; // admin
        yield ['userid' => 4, 'already_received' => false, 'expected' => Response::HTTP_FORBIDDEN]; // another collection
        yield ['userid' => 2, 'already_received' => true, 'expected' => Response::HTTP_NOT_ACCEPTABLE]; // same collection but it wants to cancel after receiving
    }

    /**
     * @dataProvider provider_list_requests
     * @return void
     */
    public function test_list_requests($userid, $expected)
    {
        $user =  User::findOrFail($userid);
        if($user->role === Role::DELIVERER->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_LIST->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        
            DeliveryRequest::factory(2)->create();

        $response = $this->getJson("/api/delivery-request", ['Authorization' => 'Bearer ' . $token]);
        if(is_array($response->decodeResponseJson()["data"])) {
            $response->assertJsonCount($expected, "data.data");
        } else {
            $response->assertStatus($expected);
        }
    }
    public function provider_list_requests()
    {
        yield ['userid' => 3, "expected" => 2];
        yield ['userid' => 2, "expected" => Response::HTTP_FORBIDDEN]; // only deliverer can see, so it will return 403
    }

    /**
     * @dataProvider provider_list_received_requests
     * @return void
     */
    public function test_list_received_requests($userid, $expected)
    {
        $user =  User::findOrFail($userid);
        if($user->role === Role::DELIVERER->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_LIST->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        
        DeliveryRequest::factory(2)->sequence(
            ['deliverer_user_id' => 3, 'accepted_at' => now()], // 3 is an example
        )->create();
         
        $response = $this->getJson("/api/deliverers/delivery-request", ['Authorization' => 'Bearer ' . $token]);

        if(is_array($response->decodeResponseJson()["data"])) {
            $response->assertJsonCount($expected, "data.data");
        } else {
            $response->assertStatus($expected);
        }
    }

    public function provider_list_received_requests()
    {
        yield ['userid' => 3, "expected" => 2];
        yield ['userid' => 6, "expected" => 0]; // 0 because of another deliverer
        yield ['userid' => 2, "expected" => Response::HTTP_FORBIDDEN]; // only deliverer can see, so it will return 403
    }

    /**
     * @dataProvider provider_all_list_received_requests
     * @return void
     */
    public function test_all_list_received_requests($userid, $expected)
    {
        $user =  User::findOrFail($userid);
        if($user->role === Role::DELIVERER->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_LIST->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        
        DeliveryRequest::factory(2)->sequence(
            ['deliverer_user_id' => 3, 'accepted_at' => now()], // 3 is an example
            [],
        )->create();
         
        $response = $this->getJson("/api/delivery-request/all", ['Authorization' => 'Bearer ' . $token]);
        if(is_array($response->decodeResponseJson()["data"])) {
            $response->assertJsonCount($expected, "data.data");
        } else {
            $response->assertStatus($expected);
        }
    }
    public function provider_all_list_received_requests()
    {
        yield ['userid' => 3, "expected" => 2];
        yield ['userid' => 6, "expected" => 1]; // 0 because of another deliverer
        yield ['userid' => 2, "expected" => Response::HTTP_FORBIDDEN]; // only deliverer can see, so it will return 403
    }

    
    /**
     * @dataProvider provider_accept_requests
     * @return void
     */
    public function test_accept_requests($userid, $id, $expected)
    {
        $user = User::findOrFail($userid);
        if($user->role === Role::DELIVERER->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_ACCEPT->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        DeliveryRequest::factory(2)->sequence(
            [],
            ['deliverer_user_id' => 3, 'accepted_at' => now()], // 3 is an example
        )->create();
        $id = DeliveryRequest::offset($id-1)->limit(1)->first()->id;
        $response = $this->putJson("/api/delivery-request/$id/accept", [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus($expected);
    }
    public function provider_accept_requests()
    {
        yield ['userid' => 3, 'id' => 1, "expected" => Response::HTTP_OK];
        yield ['userid' => 3, 'id' => 2, "expected" => Response::HTTP_NOT_ACCEPTABLE]; // because it has been accepted
        yield ['userid' => 6, 'id' => 2, "expected" => Response::HTTP_NOT_ACCEPTABLE]; // because it has been accepted
        yield ['userid' => 2, 'id' => 2, "expected" => Response::HTTP_FORBIDDEN]; // because it (collection user) does not have any access to accept
    }

    /**
     * @dataProvider provider_received_requests
     * @return void
     */
    public function test_received_requests($userid, $id, $expected)
    {
        $user = User::findOrFail($userid);
        if($user->role === Role::DELIVERER->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_FULL_DELIVERY_OP->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        DeliveryRequest::factory(3)->sequence(
            ['deliverer_user_id' => 3, 'accepted_at' => now()], // 3 is an example
            ['deliverer_user_id' => 3],
            ['deliverer_user_id' => 3, 'received_at' => now(), 'accepted_at' => now()],
        )->create();
        $id = DeliveryRequest::offset($id-1)->limit(1)->first()->id;
        $response = $this->putJson("/api/delivery-request/$id/received", [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus($expected);
    }
    public function provider_received_requests()
    {
        yield ['userid' => 3, 'id' => 1, "expected" => Response::HTTP_OK];
        yield ['userid' => 3, 'id' => 2, "expected" => Response::HTTP_NOT_ACCEPTABLE]; // because it has been accepted yet
        yield ['userid' => 3, 'id' => 3, "expected" => Response::HTTP_CONFLICT]; // because it cannot be received again
        yield ['userid' => 6, 'id' => 1, "expected" => Response::HTTP_FORBIDDEN]; // because it is not his/her delivery
        yield ['userid' => 2, 'id' => 2, "expected" => Response::HTTP_FORBIDDEN]; // because it (collection user) does not have any access to accept
    }

    /**
     * @dataProvider provider_delivered_requests
     * @return void
     */
    public function test_delivered_requests($userid, $id, $expected)
    {
        $user = User::findOrFail($userid);
        if($user->role === Role::DELIVERER->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_FULL_DELIVERY_OP->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        DeliveryRequest::factory(3)->state(new Sequence(
            ['deliverer_user_id' => 3],
            ['deliverer_user_id' => 3, 'accepted_at' => now(), 'received_at' => now()], // 3 is an example
            ['deliverer_user_id' => 3, 'accepted_at' => now(), 'received_at' => now(), 'delivered_at' => now()], // 3 is an example
        ))->create();
        $id = DeliveryRequest::offset($id-1)->limit(1)->first()->id;
        $response = $this->putJson("/api/delivery-request/$id/delivered", [], ['Authorization' => 'Bearer ' . $token]);
        $response->assertStatus($expected);
    }
    public function provider_delivered_requests()
    {
        yield ['userid' => 3, 'id' => 2, "expected" => Response::HTTP_OK];
        yield ['userid' => 3, 'id' => 1, "expected" => Response::HTTP_NOT_ACCEPTABLE]; // because it (request) has not been Received yet to deliver it !
        yield ['userid' => 3, 'id' => 3, "expected" => Response::HTTP_CONFLICT]; // because it cannot be delivered again
        yield ['userid' => 6, 'id' => 1, "expected" => Response::HTTP_FORBIDDEN]; // because it is not his/her delivery
        yield ['userid' => 2, 'id' => 1, "expected" => Response::HTTP_FORBIDDEN]; // because it (collection user) does not have any access to accept
    }

    /**
     * @return void
     */
    public function test_notification()
    {
        Notification::fake();
        DeliveryRequest::factory(2)->create();
        $user = User::find(2);
        $user->webhook_url  = "https://webhook.site/6728e249-eb55-4b70-a311-7fb051e8629d";
        $user->save();
        $id = DeliveryRequest::first()->id;
        $user =  User::findOrFail(2);
        if($user->role === Role::COLLECTION->value)
            $token = $user->createToken(config('constants.token_name'), [Permission::DELIVERY_REQUEST_CANCEL->value])->plainTextToken;
        else
            $token = $user->createToken(config('constants.token_name'), [])->plainTextToken;
        // first we will add a request by specified user id, because we want to cancel it, only if it was the same collection (other collections cannot cancel each other delivery requests)
        $this->putJson("/api/delivery-request/$id/cancel", [], ['Authorization' => 'Bearer ' . $token]);
        Notification::assertSentTo($user, DelivererChangeStatus::class);
    }
}
