<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
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

// Route of Admin
Route::get('/admins', [AdminController::class, 'index'])->middleware('auth:sanctum');
Route::get('/admins/{id}', [AdminController::class, 'show'])->middleware('auth:sanctum');
Route::get('/admin/me', [AdminController::class, 'me'])->middleware('auth:sanctum');
Route::post('/admins', [AdminController::class, 'store'])->middleware('auth:sanctum');
Route::put('/admins/{id}', [AdminController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->middleware('auth:sanctum');

// Route of Employee
Route::get('/employees', [EmployeeController::class, 'index'])->middleware('auth:sanctum');
Route::get('/employees/{id}', [EmployeeController::class, 'show'])->middleware('auth:sanctum');
Route::get('/employee/me', [EmployeeController::class, 'me'])->middleware('auth:sanctum');
Route::post('/employees', [EmployeeController::class, 'store'])->middleware('auth:sanctum');
Route::put('/employees/{id}', [EmployeeController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->middleware('auth:sanctum');

// Route of Customer
Route::get('/customers', [CustomerController::class, 'index'])->middleware('auth:sanctum');
Route::get('/customers/{id}', [CustomerController::class, 'show'])->middleware('auth:sanctum');
Route::get('/customer/me', [CustomerController::class, 'me'])->middleware('auth:sanctum');
Route::post('/customers', [CustomerController::class, 'store'])->middleware('auth:sanctum');
Route::put('/customers/{id}', [CustomerController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->middleware('auth:sanctum');

// Route of Activity Log
Route::get('/activity_logs', [ActivityLogController::class, 'index'])->middleware('auth:sanctum');
Route::get('/activity_logs/{id}', [ActivityLogController::class, 'show'])->middleware('auth:sanctum');
Route::post('/activity_logs', [ActivityLogController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/activity_logs/{id}', [ActivityLogController::class, 'destroy'])->middleware('auth:sanctum');