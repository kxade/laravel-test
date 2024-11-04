<?php

// use Illuminate\Http\Request;
use App\Http\Controllers\API\V1\PostController;
use App\Http\Controllers\API\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResources(['posts' => PostController::class]);
});