<?php

namespace App\Models\Central;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;

 
class Tenant extends BaseTenant implements TenantWithDatabase
{
    use HasDatabase, HasDomains;
    
    /**
     *
     * @return HasOne
     */
    public function domain()
    {
        return $this->hasOne(config('tenancy.domain_model'), 'tenant_id');
    }

}