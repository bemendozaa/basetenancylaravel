<?php

namespace Tests;

use App\Exceptions\TestingDatabaseNotFoundException;
use App\Models\Central\Tenant;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

trait ExistingTestDatabaseTenant
{
    
    /**
     * 
     * Buscar tenant en base al subdominio configurado al env e inicializar la conexion
     *
     * @return void
     */
    public function initializeTenant()
    {
        // Log::info("initializeTenant:".now());

        $subdomain = config('tenant.subdomain_for_tenant_testing');
        
        $url = $subdomain . '.' . config('tenant.app_url_base');
        
        $tenant = Tenant::with('domains')->whereHas('domain', fn($query) => $query->where('domain', $url))->first();

        if(!$tenant) throw new TestingDatabaseNotFoundException();

        tenancy()->initialize($tenant);

        URL::forceRootUrl('http://'.$url);
    }

}