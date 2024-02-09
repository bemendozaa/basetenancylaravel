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

    
    /**
     *
     * @param  string $subdomain
     * @return string
     */
    private function getSubdomain(string $subdomain): string
    {
        return $subdomain.'.'.config('tenant.app_url_base');
    }

    
    /**
     *
     * @param  string $subdomain
     * @return void
     */
    private function validateSubdomain(string $subdomain): void
    {
        $exist = Tenant::whereHas('domain', fn($query) => $query->where('domain', $subdomain))->first();

        if(!is_null($exist)) throw new Exception('El subdominio ya ha sido registrado.');
    }



    public function store(TenantRequest $request)
    {
        try 
        {
            $subdomain = $this->getSubdomain($request->subdomain);
            
            $this->validateSubdomain($subdomain);

            $tenant = Tenant::create([
                'tenancy_db_name' => config('tenant.prefix_database').'_'.$request->subdomain,
            ]);
    
            $tenant->domains()->create([
                'domain' => $subdomain
            ]);
    
            tenancy()->initialize($tenant);

            User::create([
                'name' => 'Administrador',
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            return [
                'success' => true,
                'message' => 'Tenant creado correctamente.',
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
