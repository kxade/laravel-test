<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PostController;

Route::prefix('user')->group(function () {
    Route::redirect('/', 'user/posts')->name('user');

    Route::get('posts', [PostController::class, 'index'])->name('user.posts.index');

    Route::get('posts/create', [PostController::class, 'create'])->name('user.posts.create');

    Route::post('posts', [PostController::class, 'store'])->name('user.posts.store');

    Route::get('posts/{post}', [PostController::class, 'show'])->name('user.posts.show');
});

Route::prefix('user')->middleware('auth')->group(function () {

    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('user.posts.edit');

    Route::put('posts/{post}/update', [PostController::class, 'update'])->name('user.posts.update');

    Route::delete('posts/{post}/delete', [PostController::class, 'destroy'])->name('user.posts.destroy');
    
});

Route::get('user/{username}/posts/', [PostController::class, 'usernamePosts'])->name('posts.username');