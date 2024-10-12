<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BaseLoginRequest;
use App\Contracts\User\AuthInterface;
use App\DataTransferObjects\AuthDTO;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
    }
    
    public function index() 
    {
        return view('login.index');
    }

    public function store(BaseLoginRequest $request) 
    {
        $auth = $this->authService->login(AuthDTO::anyLoginRequest($request));

        if ($auth) {
            return redirect()->intended('user');
        } else {
            return back()->withErrors(['failed' => 'Не получилось найти пользователя с таким логином и паролем.']);
        }
    }

    public function logout(Request $request) 
    {
        $this->authService->logout($request);

        return redirect('/');
    }
}
