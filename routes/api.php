<?php

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/student/token', [ApiAuthController::class, 'login']);
Route::post('/upload/images', [ApiController::class, 'uploadImage']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student', [ApiController::class, 'getStudent']);
    Route::put('/student/update-profile-pic', [ApiController::class, 'updateStudentProfilePic']);
    Route::get('/student/payments', [ApiController::class, 'getStudentPayments']);
});
