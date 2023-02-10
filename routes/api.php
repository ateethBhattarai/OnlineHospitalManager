<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacistController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/user', UserController::class);

Route::resource('/patient', PatientController::class);
Route::get('/patient/trashed', [PatientController::class, 'trashedData']);

Route::resource('/doctor', DoctorController::class);
Route::resource('/pharmacy', PharmacyController::class);
Route::resource('/pharmacist', PharmacistController::class);
Route::resource('/appointment', AppointmentController::class);
Route::resource('/admin', AdminController::class);
// Route::post('/prove', [DoctorController::class, 'prove']);