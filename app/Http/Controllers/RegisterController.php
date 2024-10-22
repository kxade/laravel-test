<?php

namespace App\Http\Controllers;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Http\Requests\Auth\App\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(protected AuthInterface $authService)
    {
    }

    public function index()
    {
        return view("register.index");
    }

    public function store(RegisterRequest $request)
    {
        try {
            $response = $this->authService->register(
                AuthDTO::fromAppRegisterRequest($request)
            );

            // Login the newly registered user
            Auth::login($response['user']);

            return redirect()->route('home')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Registration failed, please try again.']);
        }
    }
}
