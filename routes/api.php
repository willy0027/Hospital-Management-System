<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminUserController;


Route::prefix('v1')->group(function(){

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware(['Auth:Sanctum', 'role:admin'])->group(function(){
    Route::post('/admin/doctor', [AdminUserController::class, 'createDoctor']);
});

});











Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


