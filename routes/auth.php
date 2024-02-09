<?php

use App\Http\Controllers\Auth\Central\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Central\PasswordController;
use App\Http\Controllers\Auth\Central\RegisteredUserController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {

    Route::get('register', [RegisteredUserController::class, 'create'])->name('central.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('central.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

});


Route::middleware('auth')->group(function () {

    Route::put('password', [PasswordController::class, 'update'])->name('central.password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('central.logout');

});
