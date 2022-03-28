<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->bind(IBaseRepository::class, BaseRepository::class);
        //$this->app->bind(IPermissionRepository::class, PermissionRepository::class);

        //$this->app->bind(ProjectRepository::class);
        //$this->app->bind(UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
