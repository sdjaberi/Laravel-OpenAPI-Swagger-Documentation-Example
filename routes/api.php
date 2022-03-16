<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Admin\ProjectsController;

Route::group([
        'prefix' => 'v1',
        'as' => 'api.',
        'namespace' => 'Api\V1\Admin',
        'middleware' => ['api', 'cors'],
    ]
    ,
    function () {
        // public routes
        Route::post('/login', 'Auth\AuthController@login')->name('login.api');
        Route::post('/register', 'Auth\AuthController@register')->name('register.api');
        Route::group(['middleware' => 'auth:api']
        , function() {
            // our routes to be protected will go in here
            Route::get('/logout', 'Auth\AuthController@logout')->name('logout.api');
            Route::get('/me', 'Auth\AuthController@me')->name('me.api');

            // Permissions
            Route::apiResource('permissions', 'PermissionsController');

            // Roles
            Route::apiResource('roles', 'RolesController');

            // Users
            Route::apiResource('users', 'UsersController');

            // Projects
            Route::apiResource('projects', 'ProjectsController');
    });

    //Route::post('login', 'Auth\AuthController@login');
    //Route::post('logout', 'Auth\AuthController@logout');
    //Route::post('me', 'Auth\AuthController@me');

    //Route::post('authorize', 'Auth\AuthController@authorize');
    //Route::post('token', 'Auth\AuthController@token');
    //Route::post('refresh', 'Auth\AuthController@refresh');

});
