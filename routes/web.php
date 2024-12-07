<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\RouterController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [RouterController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'LoginProcess'])->name('login-process');

Route::middleware('auth')->group(function () {
    Route::get('/', [RouterController::class, 'index'])->name('index');
    Route::get('/batch-management', [RouterController::class, 'batchManagement'])->name('batch');
    Route::get('/management-officers', [RouterController::class, 'managementOfficers'])->name('management');

    //API Batches
    Route::post('/store-batch-process', [\App\Http\Controllers\BatchController::class, 'store'])->name('store-batch-process');
    Route::post('/get-all-batches', [\App\Http\Controllers\BatchController::class, 'index'])->name('get-all-batches');
    Route::put('/batches/{batch}', [\App\Http\Controllers\BatchController::class, 'update'])->name('batches.update');
    Route::patch('/batches/{batch}/deactivate', [\App\Http\Controllers\BatchController::class, 'deactivate'])->name('batches.deactivate');
    Route::patch('/batches/{batch}/activate', [\App\Http\Controllers\BatchController::class, 'activate'])->name('batches.activate');

    //API Management Officers
    Route::post('/store-management-officer-process', [\App\Http\Controllers\ManagementOfficerController::class, 'store'])->name('store-management-officer-process');
    Route::put('/management-officers/{id}/update', [\App\Http\Controllers\ManagementOfficerController::class, 'update']);
    Route::put('/management-officers/{id}/deactivate', [\App\Http\Controllers\ManagementOfficerController::class, 'deactivate']);
    Route::put('/management-officers/{id}/activate', [\App\Http\Controllers\ManagementOfficerController::class, 'activate']);


    Route::get('/logout', [AuthController::class, 'LogoutProcess'])->name('logout');
});
