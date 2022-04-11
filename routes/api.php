<?php

use Illuminate\Support\Facades\Route;

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
            Route::get('me', 'Auth\AuthController@me')->name('me.api');
            Route::get('logout', 'Auth\AuthController@logout')->name('logout.api');

            // Projects
            //Route::apiResource('projects', 'ProjectsController')->middleware(['auth:api', 'scopes:project_edit,project_create,project_delete']);
            Route::get('projects', 'ProjectsController@index')->name('index.api')->middleware(['auth:api', 'scopes:project_access']);
            Route::get('projects/{id}', 'ProjectsController@show')->name('show.api')->middleware(['auth:api', 'scopes:project_show']);
            Route::post('projects', 'ProjectsController@store')->name('store.api')->middleware(['auth:api', 'scopes:project_create']);
            Route::put('projects/{id}', 'ProjectsController@update')->name('update.api')->middleware(['auth:api', 'scopes:project_edit']);
            Route::delete('projects/{id}', 'ProjectsController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:project_delete']);

            // Phrases
            //Route::apiResource('phrases', 'PhrasesController')->middleware(['auth:api', 'scopes:phrase_edit,phrase_create,phrase_delete']);
            Route::get('phrases', 'PhrasesController@index')->name('index.api')->middleware(['auth:api', 'scopes:phrase_access']);
            Route::get('phrases/{id}', 'PhrasesController@show')->name('show.api')->middleware(['auth:api', 'scopes:phrase_show']);
            Route::post('phrases', 'PhrasesController@store')->name('store.api')->middleware(['auth:api', 'scopes:phrase_create']);
            Route::put('phrases/{id}', 'PhrasesController@update')->name('update.api')->middleware(['auth:api', 'scopes:phrase_edit']);
            Route::delete('phrases/{id}', 'PhrasesController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:phrase_delete']);

            // Categories
            //Route::apiResource('categories', 'CategoriesController')->middleware(['auth:api', 'scopes:category_edit,category_create,category_delete']);
            Route::get('categories', 'CategoriesController@index')->name('index.api')->middleware(['auth:api', 'scopes:category_access']);
            Route::get('categories/{id}', 'CategoriesController@show')->name('show.api')->middleware(['auth:api', 'scopes:category_show']);
            Route::post('categories', 'CategoriesController@store')->name('store.api')->middleware(['auth:api', 'scopes:category_create']);
            Route::put('categories/{id}', 'CategoriesController@update')->name('update.api')->middleware(['auth:api', 'scopes:category_edit']);
            Route::delete('categories/{id}', 'CategoriesController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:category_delete']);

            // PhraseCategories
            //Route::apiResource('phraseCategories', 'PhraseCategoriesController')->middleware(['auth:api', 'scopes:phrase_edit,phrase_create,phrase_delete']);
            Route::get('phraseCategories', 'PhraseCategoriesController@index')->name('index.api')->middleware(['auth:api', 'scopes:phrase_access']);
            Route::get('phraseCategories/{id}', 'PhraseCategoriesController@show')->name('show.api')->middleware(['auth:api', 'scopes:phrase_show']);
            Route::post('phraseCategories', 'PhraseCategoriesController@store')->name('store.api')->middleware(['auth:api', 'scopes:phrase_create']);
            Route::put('phraseCategories/{id}', 'PhraseCategoriesController@update')->name('update.api')->middleware(['auth:api', 'scopes:phrase_edit']);
            Route::delete('phraseCategories/{id}', 'PhraseCategoriesController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:phrase_delete']);

            // Languages
            //Route::apiResource('languages', 'LanguagesController')->middleware(['auth:api', 'scopes:language_edit,language_create,language_delete']);
            Route::get('languages', 'LanguagesController@index')->name('index.api')->middleware(['auth:api', 'scopes:language_access']);
            Route::get('languages/{id}', 'LanguagesController@show')->name('show.api')->middleware(['auth:api', 'scopes:language_show']);
            Route::post('languages', 'LanguagesController@store')->name('store.api')->middleware(['auth:api', 'scopes:language_create']);
            Route::put('languages/{id}', 'LanguagesController@update')->name('update.api')->middleware(['auth:api', 'scopes:language_edit']);
            Route::delete('languages/{id}', 'LanguagesController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:language_delete']);

            // Translations
            //Route::apiResource('translations', 'TranslationsController')->middleware(['auth:api', 'scopes:translation_edit,translation_create,translation_delete']);
            Route::get('translations', 'TranslationsController@index')->name('index.api')->middleware(['auth:api', 'scopes:translation_access']);
            Route::get('translations/{id}', 'TranslationsController@show')->name('show.api')->middleware(['auth:api', 'scopes:translation_show']);
            Route::post('translations', 'TranslationsController@store')->name('store.api')->middleware(['auth:api', 'scopes:translation_create']);
            Route::put('translations/{id}', 'TranslationsController@update')->name('update.api')->middleware(['auth:api', 'scopes:translation_edit']);
            Route::delete('translations/{id}', 'TranslationsController@destroy')->name('destroy.api')->middleware(['auth:api', 'scopes:translation_delete']);


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



    });

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
