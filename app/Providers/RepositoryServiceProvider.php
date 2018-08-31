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
        $this->app->bind('App\Repositories\Contracts\WarehouseRepository', 'App\Repositories\WarehouseRepository');
        $this->app->bind('App\Repositories\Contracts\SpaceRepository', 'App\Repositories\SpaceRepository');
        $this->app->bind('App\Repositories\Contracts\BoxRepository', 'App\Repositories\BoxRepository');
        $this->app->bind('App\Repositories\Contracts\RoomRepository', 'App\Repositories\RoomRepository');
    }
}
