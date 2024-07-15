<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Utils\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(RegisterRequest $request){
        $user = $this->userRepository->create($request->validationData());

        $data["token"] = $user->createToken("token")->plainTextToken;
        $data["name"] = $user->name;
        $data["email"] = $user->email;

        return Response::success($data, "User Created", HttpResponse::HTTP_CREATED);
    }

    public function login(LoginRequest $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
             $auth = Auth::user();
             $response['token'] = $auth->createToken('token')->plainTextToken;
             $response['name'] = $auth->name;
             $response['email'] = $auth->email;
             return Response::success($response, "User Login", HttpResponse::HTTP_ACCEPTED);
         } else return Response::error("Email or Password is invalid", HttpResponse::HTTP_BAD_REQUEST);

    }

    public function logout(){
        $token = Auth::user()->tokens()->delete();
        return Response::success($token, "Access token deleted", HttpResponse::HTTP_ACCEPTED);
    }

}
