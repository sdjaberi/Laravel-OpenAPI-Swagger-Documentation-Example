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
    public function count($filter = null): int;
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

                $result = parent::getAllAsync($filter, $include);

                $result = self::filter($result, $filter)->withCount(['translations', 'projects', 'users']);

                return $result;
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
                ->join('user_language', 'languages.id', '=', 'user_language.language_id')
                ->select('user_language.user_id', 'languages.*')
                ->where('user_language.user_id' , '=', $filter->userId);
        }

        if(isset($filter->projectId))
        {
            $query = $query
                ->join('language_project', 'languages.id', '=', 'language_project.language_id')
                ->select('language_project.project_id', 'languages.*')
                ->where('language_project.project_id' , '=', $filter->projectId);
        }

        if(isset($filter->translationId))
        {
            $translationId = $filter->translationId;

            $query = $query
                ->whereHas('translations', function($q) use($translationId) {
                    $q->where('id', $translationId);
                });
        }

        if(isset($filter->q))
        {
            $query = $query
                ->where('title', 'like', '%' .$filter->q. '%')
                ->orWhere('id', $filter->q)
                ->orWhere('iso_code', 'like', '%' .$filter->q. '%')
                ->orWhere('text_direction', 'like', '%' .$filter->q. '%');

                //->join('user_language', 'languages.id', '=', 'user_language.language_id')
                //->select('user_language.user_id', 'languages.*')
                //->orWhere('user_language.user_id' , '=', $filter->q)

                //->join('language_project', 'languages.id', '=', 'language_project.language_id')
                //->select('language_project.project_id', 'languages.*')
                //->orWhere('language_project.project_id' , '=', $filter->q)

                //->orWhereHas('translations', function($q1) use($translationQ) {
                    //$q1->where('id', $translationQ);
                //})

                //->distinct(['languages.id' , 'id']);

        }

        $user = Auth::user();

        if($user)
        {
            $query = $query
                ->whereIn('id', $user->languages->map(
                    function ($item) {
                        return $item->id;
                    }
                )
            );
        }

        return $query;
    }
}
