<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\Tenant\AuthenticatedSessionController;
use App\Http\Controllers\Auth\Tenant\PasswordController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])
->group(function () {
    
    Route::get('/', function () {
        return Inertia::render('Tenant/Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });
    
    Route::middleware('guest')->group(function () {
        
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('tenant.login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

    });

    
    Route::middleware('auth')->group(function () {

        Route::put('password', [PasswordController::class, 'update'])->name('tenant.password.update');
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('tenant.logout');

        Route::get('profile', [ProfileController::class, 'edit'])->name('tenant.profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('tenant.profile.update');

        Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('tenant.dashboard.index');

    });


});
