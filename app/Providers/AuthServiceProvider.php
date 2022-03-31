<?php

namespace App\Providers;

use Carbon\Carbon;
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

        Passport::tokensCan([
            'permission_create'         => 'Permission Create',
            'permission_edit'           => 'Permission edit',
            'permission_show'           => 'Permission show',
            'permission_delete'         => 'Permission delete',
            'permission_access'         => 'Permission access',

            'role_create'               => 'Role create',
            'role_edit'                 => 'Role edit',
            'role_show'                 => 'Role show',
            'role_delete'               => 'Role delete',
            'role_access'               => 'Role access',

            'user_management_access'    => 'User Management Access',
            'user_create'               => 'User create',
            'user_edit'                 => 'User edit',
            'user_show'                 => 'User show',
            'user_delete'               => 'User delete',
            'user_access'               => 'User access',

            'project_management_access' => 'Project Management Access',
            'project_create'            => 'Project create',
            'project_edit'              => 'Project edit',
            'project_show'              => 'Project show',
            'project_delete'            => 'Project delete',
            'project_access'            => 'Project access',

            'language_create'           => 'Language create',
            'language_access'           => 'Language access',
            'language_delete'           => 'Language delete',
            'language_show'             => 'Language show',
            'language_edit'             => 'Language edit',

            'category_create'               => 'category_create',
            'category_edit'                 => 'category_edit',
            'category_show'                 => 'category_show',
            'category_delete'               => 'category_delete',
            'category_access'               => 'category_access',

            'phrase_access'                 => 'phrase_access',
            'phrase_delete'                 => 'phrase_delete',
            'phrase_show'                   => 'phrase_show',
            'phrase_edit'                   => 'phrase_edit',
            'phrase_create'                 => 'phrase_create',

            'translation_management_access' => 'translation_management_access',
            'translation_access'            => 'translation_access',
            'translation_delete'            => 'translation_delete',
            'translation_show'              => 'translation_show',
            'translation_edit'              => 'translation_edit',
            'translation_create'            => 'translation_create',

            'translation_import'            => 'Import',
            'translation_export'            => 'Export',
        ]);


        //if (!app()->runningInConsole()) {
            Passport::routes();
        //};

        Passport::tokensExpireIn(Carbon::now()->addDays(1));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
    }
}
