<?php

namespace App\Services\User;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        Auth::login($user);

        return $user;
    }

    public function login(AuthDTO $dto)
    {
        $credentials = ["email" => $dto->email, "password" => $dto->password];

        if (!Auth::attempt($credentials, $dto->remember)) {
            throw new AuthenticationException("The provided credentials are incorrect.");
        }

        return Auth::user();
    }

    public function logout(Request $request)
    {
        if ($request->wantsJson()) {
            // API logout using Sanctum tokens
            if ($request->user()) {
                $request->user()->tokens()->delete();
            }
        } else {
            // Web logout using session-based authentication
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }
    }
}
