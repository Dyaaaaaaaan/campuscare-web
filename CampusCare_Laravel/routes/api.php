<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReportApiController;
use Illuminate\Support\Facades\Route;

// Task 01: Public JWT Login Endpoint
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// Task 02: Protected API Endpoints with JWT Middleware
Route::middleware('jwt')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('api.me');
    Route::apiResource('reports', ReportApiController::class)->names('api.reports');
});
