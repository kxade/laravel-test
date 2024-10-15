<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\DataTransferObjects\AuthDTO;
use App\Contracts\User\AuthInterface;
use App\Http\Requests\BaseLoginRequest;
use Illuminate\Support\Facades\Hash;


class AuthService implements AuthInterface
{
    public function getUserData($user)
    {
        $token = $user->createToken($user->name);
        return [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
    }

    public function register(AuthDTO $dto)
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);

        Auth::login($user);

        return $user;
    }

    public function login(AuthDTO $dto)
    {
        $credentials = ['email' => $dto->email, 'password' => $dto->password];
        if (!Auth::attempt($credentials, $dto->remember)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return Auth::user();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        if ($request->wantsJson()) {
            $request->user()->tokens()->delete();
        }
    }

    public function apiSource()
    {
        $this->context = 'api';
    }
}