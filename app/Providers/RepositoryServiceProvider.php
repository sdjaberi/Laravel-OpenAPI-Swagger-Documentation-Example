<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ProjectRepository;
use UserRepository;
use ProjectRepository2;
use UserRepository2;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProjectRepository::class);
        $this->app->bind(UserRepository::class);
        $this->app->bind(ProjectRepository2::class);
        $this->app->bind(UserRepository2::class);
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
