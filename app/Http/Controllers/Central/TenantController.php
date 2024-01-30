<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Central\Tenant;
use Illuminate\Http\Request;


class TenantController extends Controller
{
    
    public function records()
    {
        return Tenant::get();
    }


    public function delete($id)
    {
        $tenant = tenancy()->find($id);
        $tenant->delete();

        return [
            'success' => true,
            'message' => 'Tenant eliminado',
            'data' => $tenant,
        ];
    }


    public function store(Request $request)
    {
        $tenant = Tenant::create([
            'tenancy_db_name' => config('tenant.prefix_database').'_'.$request->subdomain,
        ]);

        $tenant->domains()->create([
            'domain' => $request->subdomain.'.'.config('tenant.app_url_base')
        ]);

        // dd($request->all());
        return [
            'success' => true,
            'data' => $tenant,
        ];
    }
    
}
