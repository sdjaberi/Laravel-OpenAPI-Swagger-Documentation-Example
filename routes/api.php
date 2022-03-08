<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Admin\ProjectsController;


Route::group([
        'prefix' => 'v1',
        'as' => 'api.',
        'namespace' => 'Api\V1\Admin',
        'middleware' => ['api'],
    ]
    , function () {

    // Permissions
    Route::apiResource('permissions', 'PermissionsController');

    // Roles
    Route::apiResource('roles', 'RolesController');

    // Users
    Route::apiResource('users', 'UsersController');

    // Projects
    Route::apiResource('projects', 'ProjectsController');


    Route::group(['prefix' => '']
    ,
    function () {
        Route::post('login', 'Auth\AuthController@login')->name('login');
        Route::post('register', 'Auth\AuthController@register');
        Route::group(['middleware' => 'api']
        , function() {
            Route::get('logout', 'Auth\AuthController@logout');
            Route::get('user', 'Auth\AuthController@user');
            Route::get('me', 'Auth\AuthController@me');
        });
    });

    //Route::post('login', 'Auth\AuthController@login');
    Route::post('logout', 'Auth\AuthController@logout');
    //Route::post('me', 'Auth\AuthController@me');

    Route::post('authorize', 'Auth\AuthController@authorize');
    Route::post('token', 'Auth\AuthController@token');
    Route::post('refresh', 'Auth\AuthController@refresh');

});
