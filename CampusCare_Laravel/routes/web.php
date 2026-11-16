<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportHistoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// CRUD Routes - ReportController (Task 01)
Route::get('/', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports', [ReportController::class, 'index']);
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
Route::get('/reports/{id}/edit', [ReportController::class, 'edit'])->name('reports.edit');
Route::put('/reports/{id}', [ReportController::class, 'update'])->name('reports.update');
Route::delete('/reports/{id}', [ReportController::class, 'destroy'])->name('reports.destroy');

// Index Routes tabel lainnya
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/report-histories', [ReportHistoryController::class, 'index'])->name('report-histories.index');
