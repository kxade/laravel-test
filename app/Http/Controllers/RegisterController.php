<?php

namespace App\Http\Controllers;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Http\Requests\Auth\App\RegisterRequest;

class RegisterController extends Controller
{
    public function __construct(protected AuthInterface $authService)
    {
        //
    }

    public function index()
    {
        return view("register.index");
    }

    public function store(RegisterRequest $request)
    {
        $this->authService->register(AuthDTO::fromAppRegisterRequest($request));

        return redirect()->route("home");
    }
}
