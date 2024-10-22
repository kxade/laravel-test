<?php

namespace App\Http\Controllers;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(protected AuthInterface $authService)
    {
    }

    public function index()
    {
        return view("login.index");
    }

    public function store(LoginRequest $request)
    {
        try {
            $response = $this->authService->login(
                AuthDTO::loginRequest($request)
            );

            Auth::login($response['user']);

            return redirect()->route('home')->with('success', 'Login successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }
}
