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
    protected $context;

    public function __construct($context = 'web')
    {
        $this->context = $context;
    }

    public function register(AuthDTO $dto)
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    
        if ($this->context === 'api') {
            $token = $user->createToken($dto->name);
            return [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
        } elseif ($this->context === 'web') {
            Auth::login($user);
        }
    }
    

    public function login(BaseLoginRequest $request)
    {
        if ($this->context === 'web') {
            // Login from Web
            if (Auth::attempt($request->validated(), $request->remember)) {
                return true;
            }
        } elseif ($this->context === 'api') {
            // Login from API
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password))
            {
                return [
                    'message' => 'The provided credintials are incorrect.'
                ];
            };

            $token = $user->createToken($user->name);
            return [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
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