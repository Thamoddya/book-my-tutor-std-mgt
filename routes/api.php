<?php

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\auth\ApiAuthController;
use Illuminate\Support\Facades\Route;

Route::post('/student/token', [ApiAuthController::class, 'login']);
Route::post('/upload/images', [ApiController::class, 'uploadImage']);

// OneSignal

Route::post('/sendNotification', [\App\Http\Controllers\config\OneSignalController::class, 'sendNotificationAPI'])->name('sendNotification');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/student-details', [ApiController::class, 'getStudent']);
    Route::put('/student/update-profile-pic', [ApiController::class, 'updateStudentProfilePic']);
    Route::get('/student/payments', [ApiController::class, 'getStudentPayments']);

    Route::get('/student/today-classes', [ApiController::class, 'getStudentTodayClasses']);
    Route::get('/class/{id}', [ApiController::class, 'getClassSchedule']);

    Route::get('/student/classes', [ApiController::class, 'getStudentEnrolledClasses']);

});
