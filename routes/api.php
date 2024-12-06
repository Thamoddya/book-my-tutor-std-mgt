<?php

use Illuminate\Support\Facades\Route;


Route::post('/store-batch-process', [\App\Http\Controllers\BatchController::class, 'store'])->name('store-batch-process');
Route::post('/get-all-batches', [\App\Http\Controllers\BatchController::class, 'index'])->name('get-all-batches');
Route::put('/batches/{batch}', [\App\Http\Controllers\BatchController::class, 'update'])->name('batches.update');
Route::patch('/batches/{batch}/deactivate', [\App\Http\Controllers\BatchController::class, 'deactivate'])->name('batches.deactivate');
Route::patch('/batches/{batch}/activate', [\App\Http\Controllers\BatchController::class, 'activate'])->name('batches.activate');

