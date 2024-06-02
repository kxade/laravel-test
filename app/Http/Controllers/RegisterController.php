<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index() {
        return view('register.index');
    }

    public function store(Request $request) {
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'max:50', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:7', 'max:50', 'confirmed'],
            'agreement' => ['accepted'],
        ]);

    
        # первый способ
        // $user = new User;
        // $user->name = $validated['name'];
        // $user->email = $validated['email'];
        // $user->password = $validated['password'];
        // $user->save();
        
        # второй способ
        // $user = new User(['name' => $validated['name']]);

        # третий способ
        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        // if (true) {
        //     return redirect()->back()->withInput();
        // }
        
        return redirect()->route('user');
    }
}
