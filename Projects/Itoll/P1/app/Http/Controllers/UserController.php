<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Enums\Role;
use App\Http\Requests\User\UpdateWebhookRequest;
use App\Http\Resources\ApiResource;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function getToken()
    {
        if(User::count() == 0)
            \App\Models\User::factory(6)->sequence(
                ['role' => Role::ADMIN->value],
                ['role' => Role::COLLECTION->value],
                ['role' => Role::DELIVERER->value]
            )->create();
        $users = User::all();
        $info = [];
        foreach($users as $user) {
            $data["user_id"] = $user["id"];
            $data["name"] = $user["role"] . ' ' . $user["id"];
            $data["role"] = $user["role"];
            $data["token"] = $user->createToken(config('constants.token_name'),
                match($user["role"]) {
                    Role::ADMIN->value => [Permission::USER_UPDATE->value],
                    Role::COLLECTION->value => [Permission::DELIVERY_REQUEST_CANCEL->value, Permission::DELIVERY_REQUEST_INSERT->value],
                    Role::DELIVERER->value => [Permission::DELIVERY_REQUEST_ACCEPT->value, Permission::DELIVERY_REQUEST_FULL_DELIVERY_OP->value, Permission::DELIVERY_REQUEST_LIST->value, Permission::DELIVERY_REQUEST_RECEIVE->value],
                }
            )->plainTextToken;
            $info[] = $data;
        }
        return new ApiResource(Response::HTTP_OK, $info ?? "");
    }

    public function setWebhook(UpdateWebhookRequest $request, $id = null)
    {
        $user = is_null($id) ? $request->user() : User::findOrFail($id);
        if($request->user()->can('update', $user)) {
            $user->webhook_url = $request->url;
            if($user->save()) {
                $status = Response::HTTP_OK;
                $data = __('api.webhook_set');
            } else {
                $status = Response::HTTP_INTERNAL_SERVER_ERROR;
            }
        } else {
            $status = Response::HTTP_FORBIDDEN;
        }
        return new ApiResource($status, $data ?? "");
    }
}
