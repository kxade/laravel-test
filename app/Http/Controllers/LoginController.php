<?php

namespace App\Http\Controllers;

use App\Contracts\User\AuthInterface;
use App\DTO\AuthDTO;
use App\Http\Requests\BaseLoginRequest;
use Illuminate\Http\Request;

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

    public function store(BaseLoginRequest $request)
    {
        try {
            $user = $this->authService->login(
                AuthDTO::anyLoginRequest($request)
            );

            return redirect()->intended("user");
        } catch (ValidationException $e) {
            return back()->withErrors([
                "failed" => "Не получилось найти пользователя с таким логином и паролем.",
            ]);
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect("/");
    }
}
