<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index() {
        return view('register.index');
    }

    public function store(Request $request) {
        $data = $request->all();

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');
        $agreement = $request->boolean('agreement');

        if ($name = $request->input('name')) {
            $name = strtoupper($name);
        }

        if (true) {
            return redirect()->back()->withInput();
        }
        
        return redirect()->route('user');
    }
}
