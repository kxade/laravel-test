<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index() 
    {
        return view('login.index');
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'email' => ['required', 'string', 'max:50', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Try to log in

        // $session = app()->make('session');

        if (Auth::attempt($validated, $request->remember)) {
            return redirect()->intended('user');
        } else {
            return back()->withErrors(['failed' => 'Не получилось найти пользователя с таким логином и паролем.']);
        }
    }

    public function logout(Request $request) 
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
