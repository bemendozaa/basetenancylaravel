<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Http\Requests\Central\TenantRequest;
use App\Http\Resources\Central\TenantCollection;
use App\Http\Resources\Central\TenantResource;
use App\Models\Central\Tenant;
use App\Models\Tenant\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    public function store(TenantRequest $request)
    {
        try 
        {
            $tenant = Tenant::create([
                'tenancy_db_name' => config('tenant.prefix_database').'_'.$request->subdomain,
            ]);
    
            $tenant->domains()->create([
                'domain' => $request->subdomain.'.'.config('tenant.app_url_base')
            ]);
    
            tenancy()->initialize($tenant);

            $user = User::create([
                'name' => 'John Doe_'.now(),
                'email' => 'john@localhost',
                'password' => 'secret',
            ]);


            return [
                'success' => true,
                'message' => 'Tenant creado correctamente.',
                'data' => $tenant,
            ];
        }
        catch(Exception $e) 
        {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }

    }
    
    
    public function delete($id)
    {
        try 
        {
            $tenant = Tenant::findOrFail($id);
            $tenant->delete();

            return [
                'success' => true,
                'message' => 'Tenant eliminado',
            ];
        }
        catch(Exception $e) 
        {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

}
