<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register',[App\Http\Controllers\AuthenticationController::class,'show']);
Route::post('/register',[App\Http\Controllers\AuthenticationController::class,'create'])->middleware('guest');

Route::get('/dashboard',[App\Http\Controllers\DashboardController::class,'show']);
Route::get('/deposits',[App\Http\Controllers\DashboardController::class,'deposit'])->name('deposit');
Route::post('/deposits',[App\Http\Controllers\DashboardController::class,'storeDeposits']);

Route::get('/withdraw',[App\Http\Controllers\DashboardController::class,'withdraw'])->name('withdrawal');
Route::post('/withdraw',[App\Http\Controllers\DashboardController::class,'deficitAmount']);
Route::get('/transfer',[App\Http\Controllers\DashboardController::class,'transfer'])->name('transfer');
Route::get('/statement',[App\Http\Controllers\DashboardController::class,'statement'])->name('statement');

Route::get('/login',[App\Http\Controllers\AuthenticationController::class,'login'])->middleware('guest');
Route::post('/login',[App\Http\Controllers\AuthenticationController::class,'check'])->middleware('guest');

Route::post('/logout',[App\Http\Controllers\AuthenticationController::class,'destroy'])->middleware('auth')->name('logout');
