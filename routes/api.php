<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/', function(){
    return response()->json([
        'status' => false,
        'message' => 'Access Denied'
    ],401);
})->name('login');

Route::get('product',[ProductController::class, 'index'])->middleware('auth:sanctum');



Route::post('registerUser',[authController::class, 'registerUser']);
Route::post('loginUser',[authController::class, 'login']);
