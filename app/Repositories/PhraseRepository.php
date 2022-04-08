<?php

namespace App\Repositories;

use App\Models\Phrase;
use App\Repositories\Base\BaseRepository;
use App\Services\Phrase\Models\PhrasePageableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

interface IPhraseRepository
{
    public function getAllWithCategoryAsync(): Builder;
    public function getAllUserPhrasesAsync($filter, $include = []): Builder;
    public function findAsync($phrase, $categoryName, $phraseCategoryName): Phrase;
    public function phrasesHasPhraseCategoryAsync($categoryName): Builder;
}

class PhraseRepository extends BaseRepository implements IPhraseRepository
{
    private $_phraseCategoryRepository;

    /**
    * PhraseRepository constructor.
    *
    * @param Phrase $model
    */
    public function __construct(Phrase $model, PhraseCategoryRepository $phraseCategoryRepository)
    {
        parent::__construct($model);
        $this->_phraseCategoryRepository = $phraseCategoryRepository;
    }

    /**
    *
    * @return Builder
    */
    public function getAllWithCategoryAsync(): Builder
    {
        return
            parent::asyncExecution(function() {
                return Phrase::with('category');
            });
    }

    /**
    *
    * @return Builder
    */
    public function getAllUserPhrasesAsync($filter, $include = []): Builder
    {
        return
            parent::asyncExecution(function() use($filter, $include) {

                $result = parent::getAllAsync($filter, $include)->withCount('translations');

                $result = self::filter($result, $filter);

                $user = Auth::user();

                if($user)
                {
                    $result = $result
                        ->whereIn('category_name', $user->categories->map(
                            function ($item) {
                                return $item->name;
                            }
                        )
                    );
                }

                return $result;
            });
    }

    /**
    * @param string $phrase$
    * @param string $categoryName
    * @param string $phraseCategoryName
    *
    * @return Phrase
    */
    public function findAsync($phrase, $categoryName, $phraseCategoryName): Phrase
    {
        return
            parent::asyncExecution(function() use($phrase, $categoryName, $phraseCategoryName) {

                $phraseCategory = ($phraseCategoryName) ? $this->_phraseCategoryRepository->getByNameAsync($phraseCategoryName)->get() : null;

                $phraseEntity = parent::getAllAsync()->where(
                    [
                        ($phrase) ? ['phrase', $phrase] : [],
                        ($categoryName) ? ['category_name', $categoryName] : [],
                        ($phraseCategory) ? ['phrase_category_id', $phraseCategory->id] : [],
                    ]
                )->first();

                return $phraseEntity;
            });
    }

    /**
    * @param string $categoryName
    *
    * @return Builder
    */
    public function phrasesHasPhraseCategoryAsync($categoryName): Builder
    {
        return
            parent::asyncExecution(function() use($categoryName) {
                return parent::getAllAsync()->where('category_name', $categoryName)->whereNotNull('phrase_category_id');
            });
    }

    /**
    * @param Builder $query
    * @param PhrasePageableFilter $filter
    *
    * @return Builder
    */
    public function filter(Builder $query = null, PhrasePageableFilter $filter = null)
    {
        if(isset($filter->phrase))
        {
            $query = $query
                ->where('phrase', '=', $filter->phrase);
        }

        if(isset($filter->category))
        {
            $query = $query
                ->join('categories', 'phrases.category_name', '=', 'categories.name')
                ->select('categories.name', 'phrases.*')
                ->where('categories.name' , '=', $filter->category);
        }

        if(isset($filter->phraseCategoryId))
        {
            $query = $query
                ->where('phrase_category_id', '=', $filter->phraseCategoryId);
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
