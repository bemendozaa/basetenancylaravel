<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Tenant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class TenantController extends Controller
{
    
    public function tenant(Request $request)
    {
        $tenant = Tenant::create([
            'tenancy_db_name' => config('tenant.prefix_database')."_".$request->subdomain,
        ]);

        $tenant->domains()->create(['domain' => $request->subdomain.".".config('tenant.app_url_base')]);

        // dd($request->all());
        return [
            'success' => true,
            'data' => $tenant,
        ];
    }
    
}
