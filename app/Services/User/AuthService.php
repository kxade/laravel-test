<?php

namespace App\Services\User;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthInterface
{
    public function getUserData($user)
    {
        $token = $user->createToken($user->name);

        return [
            "user" => $user,
            "token" => $token->plainTextToken,
        ];
    }

    public function register(AuthDTO $dto)
    {
        $user = User::create([
            "name" => $dto->name,
            "email" => $dto->email,
            "password" => $dto->password,
        ]);

        return $this->getUserData($user);
    }

    public function login(AuthDTO $dto)
    {
        $user = User::where('email', $dto->email)->first();

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw new AuthenticationException("The provided credentials are incorrect.");
        }

        return $this->getUserData($user);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out',
        ];
    }
}
