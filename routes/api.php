<?php

use App\Http\Controllers\auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/student/token', [ApiAuthController::class, 'login']);


Route::middleware('auth:sanctum')->get('/student/details', function (Request $request) {
    return $request->user();
});
