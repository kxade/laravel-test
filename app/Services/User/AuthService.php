<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\DataTransferObjects\AuthDTO;
use App\Contracts\User\AuthInterface;
use App\Http\Requests\BaseLoginRequest;
use Illuminate\Http\Request;


class AuthService implements AuthInterface
{
    public function register(AuthDTO $dto, bool $api = false)
    {
        $user = User::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
        ]);
    
        if ($api) {
            $token = $user->createToken($dto->name);
            return [
                'user' => $user,
                'token' => $token->plainTextToken,
            ];
        } else {
            Auth::login($user);
        }
    }
    

    public function login(BaseLoginRequest $request)
    {
        if (Auth::attempt($request->validated(), $request->remember)) {
            return true;
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}