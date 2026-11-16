<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ReportController::class, 'index'])->name('reports.index');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/report-histories', [ReportHistoryController::class, 'index'])->name('report-histories.index');
