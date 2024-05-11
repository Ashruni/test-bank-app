<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register',[App\Http\Controllers\AuthenticationController::class,'show']);
Route::get('/deposits',[App\Http\Controllers\DashboardController::class,'deposit'])->name('deposit');
Route::get('/withdraw',[App\Http\Controllers\DashboardController::class,'withdraw'])->name('withdrawal');
Route::get('/transfer',[App\Http\Controllers\DashboardController::class,'transfer'])->name('transfer');
Route::get('/statement',[App\Http\Controllers\DashboardController::class,'statement'])->name('statement');

// Route::get('/register',[App\Http\Controllers\AuthenticationController::class,'register'])->middleware('guest');
Route::post('/register',[App\Http\Controllers\AuthenticationController::class,'create'])->middleware('guest');

Route::get('/login',[App\Http\Controllers\AuthenticationController::class,'login']);

// Route::get('/logout',[App\Http\Controllers\AuthenticationController::class,'destroy']);
Route::post('/logout',[App\Http\Controllers\AuthenticationController::class,'destroy'])->middleware('auth')->route('logout');
