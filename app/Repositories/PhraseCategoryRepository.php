<?php

namespace App\Repositories;

use App\Models\PhraseCategory;
use App\Repositories\Base\BaseRepository;
use App\Services\PhraseCategory\Models\PhraseCategoryPageableFilter;
use Illuminate\Database\Eloquent\Builder;

interface IPhraseCategoryRepository
{
    public function getByNameAsync($phraseCategoryName): PhraseCategory;
    public function getAllPhraseCategoriesAsync($filter, $include = []): Builder;
}

class PhraseCategoryRepository extends BaseRepository implements IPhraseCategoryRepository
{
    /**
    * PhraseCategoryRepository constructor.
    *
    * @param PhraseCategory $model
    */
    public function __construct(PhraseCategory $model)
    {
        parent::__construct($model);
    }

    /**
    * @param string $phraseCategoryName
    *
    * @return PhraseCategory
    */
    public function getByNameAsync($phraseCategoryName): PhraseCategory
    {
        return
            parent::asyncExecution(function() use($phraseCategoryName) {
                return parent::getAllAsync()->where('name', $phraseCategoryName)->first();
            });
    }

    /**
    *
    * @return Builder
    */
    public function getAllPhraseCategoriesAsync($filter, $include = []): Builder
    {
        return
            parent::asyncExecution(function() use($filter, $include) {

                $result = parent::getAllAsync($filter, $include)->withCount('phrases');

                $result = self::filter($result, $filter);

                return $result;
            });
    }

    /**
    * @param Builder $query
    * @param CategoryPageableFilter $filter
    *
    * @return Builder
    */
    public function filter(Builder $result, PhraseCategoryPageableFilter $filter)
    {
        if(isset($filter->phraseCategory))
        {
            $result = $result
                ->where('name', '=', $filter->phraseCategory);
        }

        if(isset($filter->project))
        {
            $result = $result
                ->join('projects', 'phraseCategories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'phraseCategories.*')
                ->where('projects.name' , '=', $filter->project);
        }

        if(isset($filter->q))
        {
            $result = $result
                ->where('phraseCategories.name', 'like', '%' .$filter->q. '%')

                ->join('projects', 'phraseCategories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'phraseCategories.*')
                ->orWhere('projects.name' , 'like', '%' .$filter->q. '%');;
        }

        return $result;
    }
}
