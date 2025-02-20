<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\SsoProviderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Auth
Route::prefix('auth')->group(function () {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('login', [AuthController::class, 'login']);
  Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

  // reset password
  Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
  Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
  
  // googleoAuth
  Route::get('google', [SsoProviderController::class, 'googleLogin']);
  Route::get('google/redirect', [SsoProviderController::class, 'googleRedirect']);
});

/************************************** AUTHENTICATE USER **********************************/
Route::middleware('auth:sanctum')->group(function () {
  // profile
  Route::get('/me', [AuthController::class, 'me']);
  Route::post('/me/update', [AuthController::class, 'update']);
  Route::put('/me/update-password', [AuthController::class, 'updatePassword']);
  Route::delete('/me', [AuthController::class, 'destroy']);
});

/************************************** ADMIN **********************************/
// users
Route::middleware(['auth:sanctum', 'is_admin'])->prefix('admin')->group(function () {
  Route::apiResource('users', UserController::class);
  Route::post('users/{user}/update', [UserController::class, 'update']);
  Route::put('users/{user}/restore', [UserController::class, 'restore']);
  
  // musics
  Route::apiResource('musics', MusicController::class);
  Route::post('musics/{music}/update', [MusicController::class, 'update']);
  Route::put('musics/{music}/restore', [MusicController::class, 'restore']);
});
