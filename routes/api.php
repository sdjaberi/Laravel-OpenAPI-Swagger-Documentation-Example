<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Admin\ProjectsController;

Route::group([
        'prefix' => 'v1',
        'as' => 'api.',
        'namespace' => 'Api\V1\Admin',
        'middleware' => ['api', 'swfix', 'json.response'],
    ]
    ,
    function () {
        // public routes
        Route::match(['get', 'post'],'login', 'Auth\AuthController@login')->name('login.api');
        Route::match(['get', 'post'],'refreshToken', 'Auth\AuthController@refreshToken')->name('refreshToken.api');
        Route::post('register', 'Auth\AuthController@register')->name('register.api');
        Route::group(['middleware' => 'auth:api']
        ,function() {
            // our routes to be protected will go in here
            Route::get('logout', 'Auth\AuthController@logout')->name('logout.api');
            Route::get('me', 'Auth\AuthController@me')->name('me.api');

            // Permissions
            Route::apiResource('permissions', 'PermissionsController');

            // Roles
            Route::apiResource('roles', 'RolesController');

            // Users
            Route::apiResource('users', 'UsersController');
            Route::get('users', 'UsersController@index')->name('index.api')->middleware(['auth:api', 'scopes:user_access']);
            Route::get('users/{id}', 'UsersController@show')->name('show.api')->middleware(['auth:api', 'scopes:user_show']);
            Route::post('users', 'UsersController@store')->name('store.api')->middleware(['auth:api', 'scopes:user_create']);
            Route::put('users/{id}', 'UsersController@update')->name('update.api')->middleware(['auth:api', 'scopes:user_edit']);
            Route::delete('users/{id}', 'UsersController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:user_delete']);

            // Projects
            //Route::apiResource('projects', 'ProjectsController')->middleware(['auth:api', 'scopes:project_edit,project_create,project_delete']);
            Route::get('projects', 'ProjectsController@index')->name('index.api')->middleware(['auth:api', 'scopes:project_access']);
            Route::get('projects/{id}', 'ProjectsController@show')->name('show.api')->middleware(['auth:api', 'scopes:project_show']);
            Route::post('projects', 'ProjectsController@store')->name('store.api')->middleware(['auth:api', 'scopes:project_create']);
            Route::put('projects/{id}', 'ProjectsController@update')->name('update.api')->middleware(['auth:api', 'scopes:project_edit']);
            Route::delete('projects/{id}', 'ProjectsController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:project_delete']);
    });

    //Route::post('login', 'Auth\AuthController@login');
    //Route::post('logout', 'Auth\AuthController@logout');
    //Route::post('me', 'Auth\AuthController@me');

    //Route::post('authorize', 'Auth\AuthController@authorize');
    //Route::post('token', 'Auth\AuthController@token');
    //Route::post('refresh', 'Auth\AuthController@refresh');

/*
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
    */

});
