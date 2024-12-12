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
    Route::get('/students', [RouterController::class, 'students'])->name('students');
    Route::get('/payments', [RouterController::class, 'payments'])->name('payments');

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

    //API Students
    Route::post('/students', [\App\Http\Controllers\StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{student}', [\App\Http\Controllers\StudentController::class, 'update'])->name('students.update');
    Route::get('/students/{student}', [\App\Http\Controllers\StudentController::class, 'show'])->name('students.update');
    Route::patch('/students/{student}/activate', [\App\Http\Controllers\StudentController::class, 'activate'])->name('students.activate');
    Route::patch('/students/{student}/deactivate', [\App\Http\Controllers\StudentController::class, 'deactivate'])->name('students.deactivate');

    //API Payments
    Route::post('/payments/store', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');


    //RECEIPT
    Route::get('/receipt/{filename}', function ($filename) {
        $path = public_path('storage/receipts/' . $filename);

        // Log the path to ensure it is correct
        \Log::info("Receipt file path: " . $path);

        if (file_exists($path)) {
            return response()->file($path);
        }

        abort(404);
    })->name('receipt.view');


    Route::get('/logout', [AuthController::class, 'LogoutProcess'])->name('logout');
});

Route::get('/api/schools', [\App\Http\Controllers\ScoolController::class, 'searchSchools'])->name('api.schools.search');
Route::get('/api/schools/{id}', function ($id) {
    $school = App\Models\School::findOrFail($id);
    return response()->json($school);
});



