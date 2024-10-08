<?php

use App\Http\Controllers\BlogController;  
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController; 
use Illuminate\Support\Facades\Route;

Route::view('/', 'home.index')->name('home');

Route::redirect('/home', '/', 302)->name('home.redirect');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');    
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes for blog
Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{post}', [BlogController::class, 'show'])->name('blog.show');


// If nothing is found
Route::fallback(function () {
    return 'Fallback';
});