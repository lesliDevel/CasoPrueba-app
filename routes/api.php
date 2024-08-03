<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users',[UserApiController::class,'index']);
Route::post('/users', [UserApiController::class, 'store']); //para el registro de usuarios
Route::post('/login', [UserApiController::class, 'login']); //para el inicio de sesion