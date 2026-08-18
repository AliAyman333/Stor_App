<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


// Authentication
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/me', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Users
Route::get('/users/me', [UserController::class, 'user'])->middleware('auth:sanctum');
Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum');
Route::get('/users/{id}', [UserController::class, 'user_show'])->middleware('auth:sanctum');
Route::delete('/users/{id}', [UserController::class, 'user_delete'])->middleware('auth:sanctum');

// Products
Route::post('/products', [ProductController::class, 'insert'])->middleware('auth:sanctum');
Route::get('/products', [ProductController::class, 'product_index']);
Route::get('/products/{id}', [ProductController::class, 'product_show']);
Route::put('/products/{id}', [ProductController::class, 'product_update'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [ProductController::class, 'product_delete'])->middleware('auth:sanctum');

// Admins
Route::get('/admins', [AdminController::class, 'index'])->middleware('auth:sanctum');
Route::get('/admins/profile', [AdminController::class, 'me'])->middleware('auth:sanctum');
Route::get('/admins/{id}', [AdminController::class, 'show'])->middleware('auth:sanctum');
Route::post('/admins', [AdminController::class, 'store'])->middleware('auth:sanctum');
Route::put('/admins/{id}', [AdminController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->middleware('auth:sanctum');

// Employees
Route::get('/employees', [EmployeeController::class, 'index'])->middleware('auth:sanctum');
Route::get('/employees/profile', [EmployeeController::class, 'me'])->middleware('auth:sanctum');
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->middleware('auth:sanctum');
Route::post('/employees', [EmployeeController::class, 'store'])->middleware('auth:sanctum');
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->middleware('auth:sanctum');

// Customers
Route::get('/customers', [CustomerController::class, 'index'])->middleware('auth:sanctum');
Route::get('/customers/profile', [CustomerController::class, 'me'])->middleware('auth:sanctum');
Route::get('/customers/{id}', [CustomerController::class, 'show'])->middleware('auth:sanctum');
Route::post('/customers', [CustomerController::class, 'store'])->middleware('auth:sanctum');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->middleware('auth:sanctum');

// Activity logs
Route::get('/activity-logs', [ActivityLogController::class, 'index'])->middleware('auth:sanctum');
Route::get('/activity-logs/{id}', [ActivityLogController::class, 'show'])->middleware('auth:sanctum');
Route::post('/activity-logs', [ActivityLogController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/activity-logs/{id}', [ActivityLogController::class, 'destroy'])->middleware('auth:sanctum');

// Orders
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::get('/orders/{id}', [OrderController::class, 'show'])->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::put('/orders/{id}', [OrderController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->middleware('auth:sanctum');