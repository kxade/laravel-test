<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BaseLoginRequest;
use App\Contracts\User\AuthInterface;
use App\DataTransferObjects\AuthDTO;

class LoginController extends Controller
{
    public function __construct(protected AuthInterface $authService) 
    {
        //
    }
    
    public function index() 
    {
        return view('login.index');
    }

    public function store(BaseLoginRequest $request) 
    {
        try {
            $user = $this->authService->login($request->all());
    
            return redirect()->intended('user');
        } catch (ValidationException $e) {
            return back()->withErrors(['failed' => 'Не получилось найти пользователя с таким логином и паролем.']);
        }
    }

    public function logout(Request $request) 
    {
        $this->authService->logout($request);

        return redirect('/');
    }
}
