<?php

namespace App\Providers;

use App\Repositories\Tenant\Contracts\CustomerRepositoryInterface;
use App\Repositories\Tenant\Contracts\ItemRepositoryInterface;
use App\Repositories\Tenant\CustomerRepository;
use App\Repositories\Tenant\ItemRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
