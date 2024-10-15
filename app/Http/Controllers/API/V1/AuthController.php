<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTransferObjects\AuthDTO;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\BaseLoginRequest;
use App\Contracts\User\AuthInterface;

class AuthController extends Controller
{
    public function __construct(protected AuthInterface $authService) 
    {
        //
    }
    
    public function register(RegisterRequest $request) {
        $user = $this->authService->register(AuthDTO::fromApiRegisterRequest($request));
        $data = $this->authService->getUserData($user);
        return response()->json($data, 201);
    }

    public function login(BaseLoginRequest $request) {
        $user = $this->authService->login(AuthDTO::anyLoginRequest($request));
        $data = $this->authService->getUserData($user);
        return response()->json($data, 201);
    }

    public function logout(Request $request) {
        $this->authService->logout($request);
        return response()->json(['message' => 'Successfully logged out'], 201);
    }
}
