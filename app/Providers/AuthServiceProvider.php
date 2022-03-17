<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
/*
        Passport::tokensCan([
            'user_management_access' => 'User Management Access',
            'permission_create'      => 'Permission Create',
            'permission_edit'        => 'Permission edit',
            'permission_show'        => 'Permission show',
            'permission_delete'      => 'Permission delete',
            'permission_access'      => 'Permission access',
            'role_create'            => 'Role create',
            'role_edit'              => 'Role edit',
            'role_show'              => 'Role show',
            'role_delete'            => 'Role delete',
            'role_access'            => 'Role access',
            'user_create'            => 'User create',
            'user_edit'              => 'User edit',
            'user_show'              => 'User show',
            'user_delete'            => 'User delete',
            'user_access'            => 'User access',
            'project_create'         => 'Project create',
            'project_edit'           => 'Project edit',
            'project_show'           => 'Project show',
            'project_delete'         => 'Project delete',
            'project_access'         => 'Project access',
            'language_create'            => 'language_create',
            'language_access'        => 'language_access',
            'language_delete'        => 'language_delete',
            'language_show'          => 'language_show',
            'language_edit'          => 'language_edit',
        ]);
        */

        //if (!app()->runningInConsole()) {
            Passport::routes();
        //};

    }
}
