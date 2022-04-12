<?php

namespace App\Repositories;

use App\Enums\TranslationStatus;
use App\Http\Exceptions\ApiException;
use App\Models\Phrase;
use App\Repositories\Base\BaseRepository;
use App\Services\Phrase\Models\PhrasePageableFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use App\Http\Exceptions\ApiNotFoundException;
use stdClass;

interface IPhraseRepository
{
    public function getAllWithCategoryAsync(): Builder;
    public function getAllUserPhrasesAsync($filter, $include = []): Builder;
    public function count($filter = null): int;
    public function findAsync($phrase, $categoryName, $phraseCategoryName, $base_id = null);
    public function phrasesHasPhraseCategoryAsync($categoryName): Builder;
    public function upsertPhraseAsync($phrase, $categoryName, $phraseCategoryName, $base_id): Phrase;
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

                $result = parent::getAllAsync($filter, $include);

                $result = self::filter($result, $filter)->withCount('translations');

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
    * @param string $phrase$
    * @param string $categoryName
    * @param string $phraseCategoryName
    * @param integer $base_id
    *
    * @return Phrase
    */
    public function findAsync($phrase, $categoryName, $phraseCategoryName, $base_id = null)
    {
        return
            parent::asyncExecution(function() use($phrase, $categoryName, $phraseCategoryName, $base_id) {

                $phraseCategory = ($phraseCategoryName) ? $this->_phraseCategoryRepository->getByNameAsync($phraseCategoryName) : null;

                //if($phraseCategory)
                    //throw new ApiNotFoundException("Please Send a correct phrase_category_name");

                $phraseEntity = parent::getAllAsync();

                if($phrase)
                    $phraseEntity = $phraseEntity->where('phrase', $phrase);

                if($categoryName)
                    $phraseEntity = $phraseEntity->where('category_name', $categoryName);

                if($phraseCategoryName && isset($phraseCategory->id))
                    $phraseEntity = $phraseEntity->where('phrase_category_id', $phraseCategory->id);

                if($base_id)
                    $phraseEntity = $phraseEntity->where('base_id', $base_id);

                return $phraseEntity->first();
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
    * @param string $phrase$
    * @param string $categoryName
    * @param string $phraseCategoryName
    * @param integer $base_id
    *
    * @return Phrase
    */
    public function upsertPhraseAsync($phrase, $categoryName, $phraseCategoryName, $base_id): Phrase
    {
        return
            parent::asyncExecution(function() use($phrase, $categoryName, $phraseCategoryName, $base_id) {

                $phraseEntity = self::findAsync(null, $categoryName, null, $base_id);

                // Insert phrase Category Entity
                $phraseCategoryEntity = null;
                if($phraseCategoryName)
                {
                    $phraseCategoryEntity = $this->_phraseCategoryRepository->getByNameAsync($phraseCategoryName);

                    if(!$phraseCategoryEntity)
                    {
                        $phraseCategoryDto = new stdClass();
                        $phraseCategoryDto->name = $phraseCategoryName;

                        $phraseCategoryEntity = $this->_phraseCategoryRepository->storeAsync((array) $phraseCategoryDto);
                    }
                }

                // Insert New Entity
                if(!$phraseEntity) {

                    $phraseDto = new stdClass();
                    $phraseDto->phrase = $phrase;
                    $phraseDto->category_name = $categoryName;
                    $phraseDto->base_id = $base_id;
                    $phraseDto->phrase_category_id = ($phraseCategoryEntity) ? $phraseCategoryEntity->id : null;

                    $phraseEntity = self::storeAsync((array) $phraseDto);
                }
                // Update Existing Entity
                else
                {
                    $phraseEntity->phrase = $phrase;
                    $phraseEntity->category_name = $categoryName;
                    $phraseEntity->base_id = $base_id;
                    $phraseEntity->phrase_category_id = ($phraseCategoryEntity) ? $phraseCategoryEntity->id : null;

                    if($phraseEntity->getDirty() > 0)
                    {
                        foreach ($phraseEntity->translations as $translation) {
                            $translation->status = TranslationStatus::Pending;

                            $translation->update();
                        }
                    }

                    $phraseEntity = self::updateAsync($phraseEntity->id, $phraseEntity->getAttributes());
                }

                return $phraseEntity;
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

        $user = Auth::user();

        if($user)
        {
            $query = $query
                ->whereIn('category_name', $user->categories->map(
                    function ($item) {
                        return $item->name;
                    }
                )
            );
        }

        return $query;
    }

}
