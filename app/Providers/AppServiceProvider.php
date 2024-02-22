<?php

namespace App\Providers;

use App\Repositories\Tenant\CustomerRepository;
use App\Repositories\Tenant\CustomerRepositoryInterface;
use App\Repositories\Tenant\ItemRepository;
use App\Repositories\Tenant\ItemRepositoryInterface;
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
