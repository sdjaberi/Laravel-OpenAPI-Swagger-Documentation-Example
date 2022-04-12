<?php

use App\Models\Category;
use App\Models\Translation;
use App\Repositories\TranslationRepository;
use App\Services\Base\Mapper;
use App\Services\Translation\Models\TranslationPageableFilter;
use App\Services\Translation\TranslationService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')
        ->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('/debug', function () {

    $translationRepository = new TranslationService(new Mapper(), new TranslationRepository(new Translation));
    $translations = $translationRepository->getAll(new TranslationPageableFilter(), []);

    dd($translations);

    dd(Category::find('Groups')->phrases()->getQuery());
    $phraseIds = Category::find('Groups')->phrases()->get()->pluck('id')->toArray();

    $translations = Translation::whereIn('phrase_id', $phraseIds)->get();
    dd($translations);
});

Auth::routes(['register' => true]);
// Admin

Route::group(
    [
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin',
        'middleware' => ['auth']
    ],
     function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Projects
    Route::delete('projects/destroy', 'ProjectsController@massDestroy')->name('projects.massDestroy');
    Route::resource('projects', 'ProjectsController');

    // Languages
    Route::delete('languages/destroy', 'LanguagesController@massDestroy')->name('languages.massDestroy');
    Route::resource('languages', 'LanguagesController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::get('categories/{name}/translate/{to?}', 'CategoriesController@translate')->name('categories.translate');
    Route::match(['get', 'post'], 'categories/{name}/import', 'CategoriesController@import')->name('categories.import');
    Route::match(['get', 'post'], 'categories/{name}/export/{to?}', 'CategoriesController@export')->name('categories.export');
    Route::resource('categories', 'CategoriesController');

    // Phrases
    Route::delete('phrases/destroy', 'PhrasesController@massDestroy')->name('phrases.massDestroy');
    Route::resource('phrases', 'PhrasesController');

    // Translations
    Route::get('/translations/getTranslations/','TranslationsController@getTranslations')->name('translations.getTranslations');
    Route::delete('translations/destroy', 'TranslationsController@massDestroy')->name('translations.massDestroy');
    Route::post('translations/ajaxStore', 'TranslationsController@ajaxStore')->name('translations.ajaxStore');
    Route::put('translations/ajaxUpdate/{id}', 'TranslationsController@ajaxUpdate')->name('translations.ajaxUpdate');
    Route::resource('translations', 'TranslationsController');

});
