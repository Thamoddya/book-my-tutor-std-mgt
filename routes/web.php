<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\RouterController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [RouterController::class, 'login'])->name('login');
Route::get('/auth/login', [AuthController::class, 'LoginProcess'])->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', [RouterController::class, 'index'])->name('index');
});
