<?php

namespace App\Http\Controllers;

use App\Http\Requests\App\RegisterRequest;
use App\DataTransferObjects\AuthDTO;
use App\Contracts\User\AuthInterface;

class RegisterController extends Controller
{
    public function __construct(protected AuthInterface $authService) 
    {
        //
    }

    public function index() 
    {
        return view('register.index');
    }

    public function store(RegisterRequest $request) 
    {    
        // Register and log in
        $this->authService->register(
            AuthDTO::fromAppRegisterRequest($request)
        );
        
        // Redirect
        return redirect()->route('home');
    }
}
