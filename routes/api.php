<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PharmacyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/patient/login', [PatientController::class, 'login']);
Route::get('/patient/trashed', [PatientController::class, 'trashedData']);
Route::resource('/patient', PatientController::class);

Route::get('/doctor/{name}', [DoctorController::class, 'search']);
Route::resource('/doctor', DoctorController::class);
Route::resource('/pharmacy', PharmacyController::class);
Route::resource('/pharmacist', PharmacistController::class);

Route::get('/patient/pendingAppointment/{id}', [AppointmentController::class, 'patientRequest']);
// for patient
Route::get('/appointments/upcoming/{patientId}', [AppointmentController::class, 'getUpcomingAppointments']);
Route::get('/appointments/previous/{patientId}', [AppointmentController::class, 'getPreviousAppointments']);
Route::get('/appointments/doctor/cancel/{id}', [AppointmentController::class, 'getCancelledAppointments']);
// for doctor
Route::get('/appointments/doctor/previous/{id}', [AppointmentController::class, 'getUpcomingPendingAppointments']);
Route::get('/appointments/doctor/upcoming/{id}', [AppointmentController::class, 'getUpcomingApprovedAppointments']);
Route::get('/appointments/doctor/declined/{id}', [AppointmentController::class, 'getRejectedAppointments']);
Route::resource('/appointment', AppointmentController::class);

Route::post('/admin/login', [AdminController::class, 'login']);
Route::resource('/admin', AdminController::class);
// Route::post('/prove', [DoctorController::class, 'prove']);

Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/messages', [ChatController::class, 'message']);
