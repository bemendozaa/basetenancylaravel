<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;


class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Tenant/Dashboard', [
            'is-tenant' => true
            // 'is_tenant' => !is_null(tenant('id')) // use pinia
        ]);
    }
    
}
