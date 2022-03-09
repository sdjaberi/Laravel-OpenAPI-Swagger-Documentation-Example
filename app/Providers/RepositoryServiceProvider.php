<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use ProjectRepository;
use UserRepository;
use LanguageRepository;
use CategoryRepository;

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
        $this->app->bind(LanguageRepository::class);
        $this->app->bind(CategoryRepository::class);
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
