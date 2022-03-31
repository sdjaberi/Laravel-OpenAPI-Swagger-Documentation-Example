<?php

namespace App\Repositories;

use App\Models\PhraseCategory;
use App\Repositories\Base\BaseRepository;

interface IPhraseCategoryRepository
{
    public function getByNameAsync($phraseCategoryName): PhraseCategory;
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
}
