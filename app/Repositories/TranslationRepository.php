<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Translation;
use App\Repositories\Base\BaseRepository;
use App\Services\Translation\Models\TranslationPageableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

interface ITranslationRepository
{
    // Web
    public function findTranslationsCount($categoryName, $languageId): Builder;
    public function findTranslations($categoryName, $languageId): Builder;

    // Api
    public function getAllUserTranslationsAsync($filter, $include = []): Builder;
    public function count($filter = null): int;
}

class TranslationRepository extends BaseRepository implements ITranslationRepository
{
    /**
    * TranslationRepository constructor.
    *
    * @param Translation $model
    */
    public function __construct(Translation $model)
    {
        parent::__construct($model);
    }

    /**
    * @param string $categoryName
    * @param integer $languageId
    *
    * @return Builder
    */
    public function findTranslationsCount($categoryName, $languageId): Builder
    {
        return
            parent::asyncExecution(function() use($categoryName, $languageId) {
                return Translation::join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                    ->select('phrase_translations.id', 'phrase_translations.language_id', 'phrases.category_name')
                    ->where([
                        ($categoryName) ? ['category_name', $categoryName] : ['category_name'],
                        ($languageId) ? ['language_id', $languageId] : ['language_id']
                    ]);
            });
    }

    /**
    * @param string $categoryName
    * @param integer $languageId
    *
    * @return Builder
    */
    public function findTranslations($categoryName, $languageId): Builder
    {
        return
            parent::asyncExecution(function() use($categoryName, $languageId) {
                return Translation::join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                    ->select('phrase_translations.*', 'phrases.id as phrase_id', 'phrases.phrase', 'phrases.category_name')
                    ->where([
                        ($categoryName) ? ['category_name', $categoryName] : ['category_name'],
                        ($languageId) ? ['language_id', $languageId] : ['language_id']
                    ]);
            });
    }

    /**
    *
    * @return Builder
    */
    public function getAllUserTranslationsAsync($filter, $include = []): Builder
    {
        return
            parent::asyncExecution(function() use($filter, $include) {

                $result = parent::getAllAsync($filter, $include);

                $result = self::filter($result, $filter);

                return $result;
            });
    }

    /**
    * @param array $categoriesName
    * @param array $languagesId
    *
    * @return Builder
    */
    public function findAllUserTranslations($categoriesName = [], $languagesId = []): Builder
    {
        return
            parent::asyncExecution(function() use($categoriesName, $languagesId) {
                return
                    Translation::join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                        ->select('phrase_translations.*', 'phrases.id as phrase_id', 'phrases.phrase', 'phrases.category_name')
                        ->whereIn([
                            (count($categoriesName) > 0) ? ['category_name', $categoriesName] : ['category_name'],
                            (count($languagesId) > 0) ? ['language_id', $languagesId] : ['language_id']
                        ]);
            });
    }

    /**
    *
    * @return integer
    */
    public function count($filter = null): int
    {
        return
            parent::asyncExecution(function() use($filter) {

                $result = parent::getCount();

                $result = self::filter($result, $filter);

                return $result->count();
            });
    }

    /**
    * @param Builder $query
    * @param TranslationPageableFilter $filter
    *
    * @return Builder
    */
    public function filter(Builder $query = null, TranslationPageableFilter $filter = null)
    {
        if(isset($filter->translation))
        {
            $query = $query
                ->where('translation', '=', $filter->translation);
        }

        if(isset($filter->phraseId))
        {
            $query = $query
                ->where('phrase_id', '=', $filter->phraseId);
        }

        if(isset($filter->phrase))
        {
            $query = $query
                ->join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                ->select('phrases.phrase', 'phrase_translations.*')
                ->where('phrases.phrase' , '=', $filter->phrase);
        }

        if(isset($filter->languageId))
        {
            $query = $query
                ->where('language_id', '=', $filter->languageId);
        }

        if(isset($filter->language))
        {
            $query = $query
                ->join('languages', 'phrase_translations.language_id', '=', 'languages.id')
                ->select('languages.title', 'phrase_translations.*')
                ->where('languages.title' , '=', $filter->language);
        }

        if(isset($filter->userId))
        {
            $query = $query
                ->where('user_id', '=', $filter->userId);
        }

        if(isset($filter->user))
        {
            $query = $query
                ->join('useres', 'phrase_translations.user_id', '=', 'users.id')
                ->select('users.name', 'phrase_translations.*')
                ->where('users.name' , '=', $filter->user);
        }

        if(isset($filter->q))
        {
            $query = $query
                ->where('translation', 'like', '%' .$filter->q. '%')

                //Phrases
                ->orWhere('phrase_id', '=', $filter->q)
                ->join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                ->select('phrases.phrase', 'phrase_translations.*')
                ->orWhere('phrases.phrase' , 'like', '%' .$filter->q. '%')

                //Languages
                ->orWhere('language_id', '=', $filter->q)
                ->join('languages', 'phrase_translations.language_id', '=', 'languages.id')
                ->select('languages.title', 'phrase_translations.*')
                ->orWhere('languages.title' , 'like', '%' .$filter->q. '%')

                //Users
                ->orWhere('user_id', '=', $filter->q)
                ->join('users', 'phrase_translations.user_id', '=', 'users.id')
                ->select('users.name', 'phrase_translations.*')
                ->orWhere('users.name' , 'like', '%' .$filter->q. '%');
        }

        $user = Auth::user();
        if($user)
        {
            $userCategories = $user->categories->pluck('name')->toArray();

            //dd($filter->category, in_array($filter->category, (array)$userCategories, false));

            //$phraseIds = Category::find($filter->category)->phrases()->get()->pluck('id')->toArray();
            //dd($phraseIds);
            //$translations = Translation::whereIn('phrase_id', $phraseIds)->get();
            //dd($translations);

            $query = $query
                    ->join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                    ->select('phrases.category_name', 'phrase_translations.*');

            if(isset($filter->category) && in_array($filter->category, $userCategories))
            {
                $query = $query
                    ->where('phrases.category_name' , $filter->category);
            }
            else
            {
                $query = $query
                    ->whereIn('phrases.category_name' , $userCategories);
            }
        }

        return $query;
    }
}
