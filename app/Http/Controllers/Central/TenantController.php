<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\TenantRequest;
use App\Http\Resources\Central\TenantCollection;
use App\Http\Resources\Central\TenantResource;
use App\Models\Central\Tenant;
use Illuminate\Http\Request;


class TenantController extends Controller
{
    
    public function record($id)
    {
        $record = Tenant::with('domain')->find($id);

        return new TenantResource($record);
    }


    public function records()
    {
        return new TenantCollection(Tenant::latest()->paginate(5));
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


    public function store(TenantRequest $request)
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
