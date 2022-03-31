<?php

namespace App\Repositories;

use App\Models\Translation;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

interface ITranslationRepository
{
    public function findTranslationsCount($categoryName, $languageId): Builder;
    public function findTranslations($categoryName, $languageId): Builder;
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
}
