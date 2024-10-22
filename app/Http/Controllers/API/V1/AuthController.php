<?php

namespace App\Http\Controllers\API\V1;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Api\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthInterface $authService)
    {
    }

    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register(
            AuthDTO::fromApiRegisterRequest($request)
        );

        return response()->json($response, 201);
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->login(AuthDTO::loginRequest($request));

        return response()->json($response, 201);
    }

    public function logout(Request $request)
    {
        $response = $this->authService->logout($request);

        return response()->json($response, 201);
    }
}
