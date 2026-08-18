<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


// مسار جلب بيانات المستخدم المصادق عليه
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Route of Authentication
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

//Route of User
Route::get('/user', [UserController::class, 'user'])->middleware('auth:sanctum');
Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/user_show/{id}', [UserController::class, 'user_show'])->middleware('auth:sanctum');
Route::delete('/user_delete/{id}', [UserController::class, 'user_delete'])->middleware('auth:sanctum');


// Route of Product
Route::post('/insert', [ProductController::class, 'insert']);
Route::get('/product_index', [ProductController::class, 'product_index']);
Route::get('/product_show/{id}', [ProductController::class, 'product_show']);
Route::put('/product_update/{id}', [ProductController::class, 'product_update']);
Route::delete('/product_delete/{id}', [ProductController::class, 'product_delete']);