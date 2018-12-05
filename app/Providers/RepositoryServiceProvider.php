<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Contracts\CategoryRepository', 'App\Repositories\CategoryRepository');
        $this->app->bind('App\Repositories\Contracts\AreaRepository', 'App\Repositories\AreaRepository');
        $this->app->bind('App\Repositories\Contracts\SpaceRepository', 'App\Repositories\SpaceRepository');
        $this->app->bind('App\Repositories\Contracts\ShelvesRepository', 'App\Repositories\ShelvesRepository');
        $this->app->bind('App\Repositories\Contracts\BoxRepository', 'App\Repositories\BoxRepository');
        $this->app->bind('App\Repositories\Contracts\DashboardRepository', 'App\Repositories\DashboardRepository');
        $this->app->bind('App\Repositories\Contracts\UserRepository', 'App\Repositories\UserRepository');
        $this->app->bind('App\Repositories\Contracts\OrderRepository', 'App\Repositories\OrderRepository');
        $this->app->bind('App\Repositories\Contracts\OrderDetailRepository', 'App\Repositories\OrderDetailRepository');        
        $this->app->bind('App\Repositories\Contracts\ReturnBoxesRepository', 'App\Repositories\ReturnBoxesRepository');     
        $this->app->bind('App\Repositories\Contracts\DeliveryFeeRepository', 'App\Repositories\DeliveryFeeRepository');     
        $this->app->bind('App\Repositories\Contracts\PaymentRepository', 'App\Repositories\PaymentRepository');
    }
}
