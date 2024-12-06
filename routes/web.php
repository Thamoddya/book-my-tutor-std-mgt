<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\RouterController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [RouterController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'LoginProcess'])->name('login-process');

Route::middleware('auth')->group(function () {
    Route::get('/', [RouterController::class, 'index'])->name('index');

    Route::get('/logout', [AuthController::class, 'LogoutProcess'])->name('logout');
});
