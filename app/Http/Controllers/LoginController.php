<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        return view('login.index');
    }

    public function store(Request $request) {
        $session = app()->make('session');

        dd($session);

        if (true) {
            return redirect()->back()->withInput();
        }
        
        return redirect()->route('user');
    }
}
