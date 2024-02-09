<?php

use App\Http\Controllers\Central\DashboardController;
use App\Http\Controllers\Central\ProfileController;
use App\Http\Controllers\Central\TenantController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Central/Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('central.dashboard.index');

    Route::get('profile', [ProfileController::class, 'edit'])->name('central.profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('central.profile.update');

    Route::prefix('tenants')->group(function(){

        Route::controller(TenantController::class)->group(function(){

            Route::post('', 'store');
            Route::get('records', 'records');
            Route::get('record/{id}', 'record');
            Route::delete('{id}', 'delete');
            
        });
        
    });

});

require __DIR__.'/auth.php';
