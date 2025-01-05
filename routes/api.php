<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
  Route::apiResource('products', ProductController::class);
});

Route::post('signup', [AuthController::class, 'signup'])->name('auth.signup');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
