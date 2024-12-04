<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PasswordResetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::resource('auth', AuthController::class)->names([
//     'register' => 'auth.register',
// ]);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordResetController::class, 'resetPassword']);
Route::get('/reset-password', [PasswordResetController::class, 'showResetPassword']);

// Route::group(['middleware' => ['web']], function () {
//     Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle']);
//     Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
// });
