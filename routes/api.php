<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductController;


Route::group([
        'prefix' => 'v1',
        'as' => 'api.',
        'namespace' => 'Api\V1\Admin',
        'middleware' => ['api'],
    ]
    , function () {

    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Projects
    Route::apiResource('projects', 'ProjectsApiController');


    Route::group(['prefix' => '']
    ,
    function () {
        Route::post('login', 'Auth\AuthApiController@login')->name('login');
        Route::post('register', 'Auth\AuthApiController@register');
        Route::group(['middleware' => 'api']
        , function() {
            Route::get('logout', 'Auth\AuthApiController@logout');
            Route::get('user', 'Auth\AuthApiController@user');
            Route::get('me', 'Auth\AuthApiController@me');
        });
    });

    //Route::post('login', 'Auth\AuthApiController@login');
    Route::post('logout', 'Auth\AuthApiController@logout');
    //Route::post('me', 'Auth\AuthApiController@me');

    Route::post('authorize', 'Auth\AuthApiController@authorize');
    Route::post('token', 'Auth\AuthApiController@token');
    Route::post('refresh', 'Auth\AuthApiController@refresh');

});
