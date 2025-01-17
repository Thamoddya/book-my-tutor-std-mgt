<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassScheduleController;
use App\Http\Controllers\RouterController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [RouterController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'LoginProcess'])->name('login-process');

Route::middleware('auth')->group(function () {
    Route::get('/', [RouterController::class, 'index'])->name('index');
    Route::get('/batch-management', [RouterController::class, 'batchManagement'])->name('batch');

    Route::get('/students', [RouterController::class, 'students'])->name('students');
    Route::get('/schools', [RouterController::class, 'schools'])->name('schools');
    Route::get('/payments', [RouterController::class, 'payments'])->name('payments');
    Route::get('/profile-user', [RouterController::class, 'profile'])->name('profile');
    Route::get('/classes', [RouterController::class, 'classes'])->name('classes');
    Route::get('/class-schedule', [RouterController::class, 'classSchedule'])->name('class-schedule');

    Route::put('/profile-update', [\App\Http\Controllers\Controller::class, 'updateUser'])->name('profile.update');

    //Super_admin middleware
    Route::middleware('role:Super_Admin')->group(function () {
        Route::get('/systemLog', [RouterController::class, 'systemLog'])->name('systemLog');
        Route::get('/management-officers', [RouterController::class, 'managementOfficers'])->name('management');
        Route::get('/studentReports', [RouterController::class, 'studentReports'])->name('studentReports');
        Route::get('/PaymentReports', [RouterController::class, 'PaymentReports'])->name('PaymentReports');
    });

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
    Route::get('/students/{student}', [\App\Http\Controllers\StudentController::class, 'show'])->name('students.get');
    Route::patch('/students/{student}/activate', [\App\Http\Controllers\StudentController::class, 'activate'])->name('students.activate');
    Route::patch('/students/{student}/deactivate', [\App\Http\Controllers\StudentController::class, 'deactivate'])->name('students.deactivate');

    //API Payments
    Route::post('/payments/store', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');

    Route::get('/payments/{payment}/edit', [\App\Http\Controllers\PaymentController::class, 'edit'])->name('payments.edit');
    Route::put('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'update'])->name('payments.update');
    Route::delete('/payments/{payment}', [\App\Http\Controllers\PaymentController::class, 'destroy'])->name('payments.destroy');

    //API Classes
    Route::post('/classes/store-ajax', [ClassesController::class, 'storeAjax'])->name('classes.store.ajax');
    Route::get('/classes/load-data', [ClassesController::class, 'loadData'])->name('classes.load.data');
    Route::post('/classes/update/{id}', [ClassesController::class, 'updateAjax'])->name('classes.update.ajax');
    Route::delete('/classes/{id}', [ClassesController::class, 'destroy'])->name('classes.destroy');

    Route::get('/classes/{id}/students', [ClassesController::class, 'getClassStudents'])->name('classes.get.students');
    Route::post('/classes/{id}/add-student', [ClassesController::class, 'addStudentToClass'])->name('classes.add.student');
    Route::delete('/classes/{class_id}/remove-student/{student_id}', [ClassesController::class, 'removeStudentFromClass'])->name('classes.remove.student');

    //API Class Schedule
    Route::get('/class-schedules/load', [ClassScheduleController::class, 'loadSchedules'])->name('class-schedules.load');
    Route::post('/class-schedules', [ClassScheduleController::class, 'store'])->name('class-schedules.store');
    Route::put('/class-schedules/{id}', [ClassScheduleController::class, 'update'])->name('class-schedules.update');
    Route::delete('/class-schedules/{id}', [ClassScheduleController::class, 'destroy'])->name('class-schedules.destroy');
    Route::get('/class-schedules/{id}', [ClassScheduleController::class, 'show'])->name('class-schedules.show');

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


Route::get('/schools/create', [RouterController::class, 'createSchool'])->name('schools.create');
Route::post('/schools/store', [\App\Http\Controllers\ScoolController::class, 'store'])->name('schools.store');
Route::get('/schools/{school}/edit', [\App\Http\Controllers\ScoolController::class, 'edit'])->name('schools.edit');
Route::put('/schools/{school}', [\App\Http\Controllers\ScoolController::class, 'update'])->name('schools.update');
Route::delete('/schools/{school}', [\App\Http\Controllers\ScoolController::class, 'destroy'])->name('schools.destroy');
Route::get('/schools/{school}', [\App\Http\Controllers\ScoolController::class, 'show'])->name('schools.show');
