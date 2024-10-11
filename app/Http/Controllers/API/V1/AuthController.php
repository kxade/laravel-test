<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTransferObjects\AuthDTO;
use App\Http\Requests\Api\RegisterRequest;
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

    public function login(Request $request) {
        return 'login';
    }

    public function logout(Request $request) {
        return 'logout';
    }
}
