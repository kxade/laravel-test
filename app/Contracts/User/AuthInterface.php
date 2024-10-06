<?php

namespace App\Contracts\User;

use App\DataTransferObjects\AuthDTO;
use App\Http\Requests\App\LoginRequest;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function register(AuthDTO $dto);

    public function login(LoginRequest $request);

    public function logout(Request $request);
}