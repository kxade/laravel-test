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
    protected $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
        $this->authService->apiSource();
    }
    
    public function register(RegisterRequest $request) {
        $response = $this->authService->register(AuthDTO::fromApiRegisterRequest($request));
        return response()->json($response, 201);
    }

    public function login(BaseLoginRequest $request) {
        $response = $this->authService->login(AuthDTO::anyLoginRequest($request));
        return response()->json($response, 201);
    }

    public function logout(Request $request) {
        $response = $this->authService->logout($request);
        return response()->json($response, 201);
    }
}
