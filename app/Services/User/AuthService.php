<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\DataTransferObjects\RegisterDTO;
use App\Contracts\User\AuthInterface;


class AuthService implements AuthInterface
{
    public function register(RegisterDTO $dto)
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);

        Auth::login($user);
    }
}