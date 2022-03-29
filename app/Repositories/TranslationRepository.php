<?php

namespace App\Repositories;

use App\Models\Translation;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface ITranslationRepository
{
    public function findTranslationsCount($categoryName, $languageId): Collection;
    public function findTranslations($categoryName, $languageId): Collection;
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
    * @return Collection
    */
    public function findTranslationsCount($categoryName, $languageId): Collection
    {
        return
            parent::asyncExecution(function() use($categoryName, $languageId) {
                return Translation::join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                    ->select('phrase_translations.id', 'phrase_translations.language_id', 'phrases.category_name')
                    ->where([
                        ($categoryName) ? ['category_name', $categoryName] : [],
                        ($languageId) ? ['language_id', $languageId] : []
                    ]);
            });
    }

    /**
    * @param string $categoryName
    * @param integer $languageId
    *
    * @return Collection
    */
    public function findTranslations($categoryName, $languageId): Collection
    {
        return
            parent::asyncExecution(function() use($categoryName, $languageId) {
                return Translation::join('phrases', 'phrase_translations.phrase_id', '=', 'phrases.id')
                    ->select('phrase_translations.*', 'phrases.*')
                    ->where([
                        ($categoryName) ? ['category_name', $categoryName] : [],
                        ($languageId) ? ['language_id', $languageId] : []
                    ]);
            });
    }
}
