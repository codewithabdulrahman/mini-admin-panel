<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/getDashboardStats', [HomeController::class, 'dashboardData']);
    Route::resource('company', CompanyController::class);
    Route::post('/company/{id}', [CompanyController::class, 'update']);
    Route::resource('employee', EmployeeController::class);
});

Route::post('/login', [AuthController::class, 'login']);