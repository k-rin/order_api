<?php

namespace App\Providers;

use App\Repositories\Contracts\IBnbRepository;
use App\Repositories\Contracts\IOrderCurRepository;
use App\Repositories\Contracts\IOrderRepository;
use App\Repositories\BnbRepository;
use App\Repositories\OrderCurRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(IBnbRepository::class, BnbRepository::class);
        $this->app->bind(IOrderCurRepository::class, OrderCurRepository::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
    }
}
