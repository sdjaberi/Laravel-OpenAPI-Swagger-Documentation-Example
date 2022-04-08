<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Base\BaseRepository;
use App\Services\Language\Models\LanguagePageableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

interface ILanguageRepository
{
    public function getAllNotPrimaryAsync(): Builder;
    public function getAllActiveAsync(): Builder;
    public function getAllUserLanguagesAsync($filter, $include = []): Builder;
    public function getPrimaryAsync(): Language;
}

class LanguageRepository extends BaseRepository implements ILanguageRepository
{
    /**
    * LanguageRepository constructor.
    *
    * @param Language $model
    */
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }

    /**
    *
    * @return Builder
    */
    public function getAllNotPrimaryAsync(): Builder
    {
        return
            parent::asyncExecution(function() {
                return parent::getAllAsync()->where('is_primary', 0);
            });
    }

    /**
    *
    * @return Builder
    */
    public function getAllActiveAsync(): Builder
    {
        return
            parent::asyncExecution(function() {
                return parent::getAllAsync()->where('active', 1);
            });
    }

    /**
    *
    * @return Builder
    */
    public function getAllUserLanguagesAsync($filter, $include = []): Builder
    {
        return
            parent::asyncExecution(function() use($filter, $include) {

                $result = parent::getAllAsync($filter, $include)->withCount(['translations', 'projects', 'users']);

                $result = self::filter($result, $filter);

                $user = Auth::user();

                if($user)
                {
                    $result = $result
                        ->whereIn('id', $user->languages->map(
                            function ($item) {
                                return $item->id;
                            }
                        )
                    );
                }

                return $result;
            });
    }

    /**
    *
    * @return Language
    */
    public function getPrimaryAsync(): Language
    {
        return
            parent::asyncExecution(function() {
                return parent::getAllAsync()->where('is_primary', 1)->first();
            });
    }

    /**
    * @param Builder $query
    * @param LanguagePageableFilter $filter
    *
    * @return Builder
    */
    public function filter(Builder $query = null, LanguagePageableFilter $filter = null)
    {
        if(isset($filter->language))
        {
            $query = $query
                ->where('title', '=', $filter->language);
        }

        if(isset($filter->userId))
        {
            $query = $query
                ->users->where('id', $filter->userId);
        }

        if(isset($filter->user))
        {
            $query = $query
                ->users->where('name', $filter->user);
        }

        if(isset($filter->projectId))
        {
            $query = $query
                ->join('language_project', 'phrases.phrase_category_id', '=', 'language_project.project_id')
                ->select('phrase_categories.name', 'phrases.*')
                ->where('phrase_categories.name' , '=', $filter->phraseCategory);

                ->projects->where('id', $filter->projectId);
        }

        if(isset($filter->project))
        {
            $query = $query
                ->projects->where('name', $filter->project);
        }

        if(isset($filter->translationId))
        {
            $query = $query
                ->translations->where('id', $filter->translationId);
        }

        if(isset($filter->translation))
        {
            $query = $query
                ->translations->where('translation', $filter->translation);
        }

        if(isset($filter->phraseCategory))
        {
            $query = $query
                ->join('phrase_categories', 'phrases.phrase_category_id', '=', 'phrase_categories.id')
                ->select('phrase_categories.name', 'phrases.*')
                ->where('phrase_categories.name' , '=', $filter->phraseCategory);
        }

        if(isset($filter->q))
        {
            $query = $query
                ->where('phrase', 'like', '%' .$filter->q. '%')

                ->join('categories', 'phrases.category_name', '=', 'categories.name')
                ->select('categories.name', 'phrases.*')
                ->orWhere('categories.name' , 'like', '%' .$filter->q. '%')

                ->join('phrase_categories', 'phrases.phrase_category_id', '=', 'phrase_categories.id')
                ->select('phrase_categories.name', 'phrases.*')
                ->orWhere('phrase_categories.name' , 'like', '%' .$filter->q. '%');
        }

        return $query;
    }
}
