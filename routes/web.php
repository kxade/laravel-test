<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\TestController;    
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Posts\CommentController;
use App\Http\Middleware\LogMiddleware;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'home.index')->name('home');

Route::redirect('/home', '/', 302)->name('home.redirect');

Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');

Route::post('/login', [LoginController::class, 'store'])->name('login.store');

// Подтвержение авторизации
// Route::get('/login/{user}/confirmation', LoginController::class, 'edit')->name('login.confirmation');

// Route::post('/login/{user}/confirm', LoginController::class, 'store')->name('login.confirm');

// CRUD (create, update, delete)
Route::get('/test', TestController::class)->name('test')->middleware([LogMiddleware::class, 'token:secret,fook']);


// Routes for blog
Route::get('blog', [BlogController::class, 'index'])->name('blog.index')->middleware('test');
Route::get('blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::post('blog/{post}/like', [BlogController::class, 'like'])->name('blog.like');



// Routes for comments
Route::resource('posts/{post}/comments', CommentController::class)->only([
    'index', 'show', 'edit',
]);

// If nothing is found
Route::fallback(function () {
    return 'Fallback';
});