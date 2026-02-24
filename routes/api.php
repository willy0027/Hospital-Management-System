<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AppoitmentController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\DoctorController;

Route::prefix('v1')->group(function(){

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', 'role:patient'])->group(function (){
    Route::post('/inquiry', [InquiryController::class, 'store']);
});

Route::middleware('auth:sanctum')->get('/doctor/dashboard', [DoctorController::class, 'dashboard']);



Route::middleware(['auth:Sanctum', 'role:admin'])->group(function(){
    Route::post('/admin/doctor', [AdminUserController::class, 'createDoctor']);
    Route::post('/appoitments', [AppoitmentController::class, 'book']);
    Route::delete('/appoitments/{id}', [AppoitmentController::class, 'cancel']);
    Route::get('/inquiries', [InquiryController::class, 'index']);
    Route::patch('/inquiries/{id}/reply', [InquiryController::class, 'reply']);


});

});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


