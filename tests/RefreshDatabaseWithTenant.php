<?php

namespace Tests;

use App\Models\Central\Tenant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\ParallelTesting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

trait RefreshDatabaseWithTenant
{
    use RefreshDatabase {
        beginDatabaseTransaction as parentBeginDatabaseTransaction;
    }


    /**
     * The database connections that should have transactions.
     *
     * `null` is the default landlord connection
     * `tenant` is the tenant connection
     */
    protected array $connectionsToTransact = [null, 'tenant'];


    /**
     * We need to hook initialize tenancy _before_ we start the database
     * transaction, otherwise it cannot find the tenant connection.
     */
    public function beginDatabaseTransaction()
    {
        Log::info("initializeTenant: ".now());

        $this->initializeTenant();

        $this->parentBeginDatabaseTransaction();
    }


    public function initializeTenant()
    {
        $tenant_id = 'testacme2'; //subdomain
        $url = $tenant_id . '.' . config('tenant.app_url_base');

        $tenant = Tenant::firstOr(function () use ($tenant_id, $url) {

            config([
                'tenancy.database.prefix' => config('tenant.prefix_database') . ParallelTesting::token() . '_'
            ]);
            
            $db_name = config('tenancy.database.prefix') . $tenant_id;

            DB::unprepared("DROP DATABASE IF EXISTS `{$db_name}`");

            $tenant = Tenant::create(['id' => $tenant_id]);

            if (!$tenant->domains()->count()) 
            {
                $tenant->domains()->create(['domain' => $url ]);
            }

            return $tenant;
        });

        tenancy()->initialize($tenant);

        URL::forceRootUrl('http://'.$url);
    }

}