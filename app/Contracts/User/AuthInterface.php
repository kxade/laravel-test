<?php

namespace App\Contracts\User;

use App\DTO\AuthDTO;
use Illuminate\Http\Request;

interface AuthInterface
{
    public function register(AuthDTO $dto);

    public function login(AuthDTO $dto);

    public function logout(Request $request);
}
