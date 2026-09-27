<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/users/{user}/licenses', [UserController::class, 'licenses']);
Route::post('/orders', [OrderController::class, 'store']);
