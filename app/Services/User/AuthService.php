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
        if ($this->context === 'web') {
            // Login from Web
            $credentials = ['email' => $dto->email, 'password' => $dto->password];
            if (Auth::attempt($credentials, $dto->remember)) {
                return true;
            }
        
        } elseif ($this->context === 'api') {
            // Login from API
            $user = User::where('email', $dto->email)->first();

            if (!$user || !Hash::check($dto->password, $user->password))
            {
                return [
                    'message' => 'The provided credintials are incorrect.'
                ];
            };

            return self::getToken($user);
        }    
    }

    public function logout(Request $request)
    {
        if ($this->context === 'web') {
            // Login from Web
            Auth::logout();
    
            $request->session()->invalidate();
            $request->session()->regenerateToken();

        } elseif (($this->context === 'api')) {

            $request->user()->tokens()->delete();

            return [
                'message' => 'You are logged out',
            ];
        }
    }

    public function apiSource()
    {
        $this->context = 'api';
    }
}