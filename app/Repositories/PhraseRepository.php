<?php

namespace App\Repositories;

use App\Models\Phrase;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface IPhraseRepository
{
    public function getAllWithCategory(): Collection;
    public function find($phrase, $categoryName, $phraseCategoryName): Phrase;
    public function phrasesHasPhraseCategory($categoryName): Collection;
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
    * @return Collection
    */
    public function getAllWithCategory(): Collection
    {
        return
            parent::asyncExecution(function() {
                return Phrase::with('category')->get();
            });
    }

    /**
    * @param string $phrase$
    * @param string $categoryName
    * @param string $phraseCategoryName
    *
    * @return Phrase
    */
    public function find($phrase, $categoryName, $phraseCategoryName): Phrase
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
    * @return Collection
    */
    public function phrasesHasPhraseCategory($categoryName): Collection
    {
        return
            parent::asyncExecution(function() use($categoryName) {
                return parent::getAllAsync()->where('category_name', $categoryName)->whereNotNull('phrase_category_id');
            });
    }

}
