<?php

namespace App\Http\Controllers;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(protected AuthInterface $authService)
    {
        //
    }

    public function index()
    {
        return view("login.index");
    }

    public function store(LoginRequest $request)
    {
        try {
            $user = $this->authService->login(
                AuthDTO::loginRequest($request)
            );

            return redirect()->intended("user");
        } catch (ValidationException $e) {

            return back()->withErrors([
                "failed" => "Не получилось найти пользователя с таким логином и паролем.",
            ])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect("/");
    }
}
