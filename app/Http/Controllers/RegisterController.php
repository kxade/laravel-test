<?php

namespace App\Http\Controllers;

use App\Http\Requests\App\RegisterRequest;
use App\DataTransferObjects\AuthDTO;
use App\Contracts\User\AuthInterface;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(AuthInterface $authService)
    {
        $this->authService = $authService;
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
