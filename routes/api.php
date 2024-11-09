<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

Route::post('signup', [AuthController::class, 'signup'])->name('auth.signup');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
