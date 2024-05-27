<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PostController;


Route::prefix('user')->as('user.')->group(function () {
    Route::redirect('', 'user/posts')->name('user');

    Route::get('posts', [PostController::class, 'index'])->name('posts.index');

    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');

    Route::post('posts', [PostController::class, 'store'])->name('posts.store');

    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

    Route::put('posts/{post}/update', [PostController::class, 'update'])->name('posts.update');

    Route::delete('posts/{post}/delete', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::put('posts/{post}/like', [PostController::class, 'like'])->name('posts.like');
});