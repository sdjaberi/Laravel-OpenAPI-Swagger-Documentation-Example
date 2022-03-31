<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

interface ILanguageRepository
{
    public function getAllNotPrimaryAsync(): Builder;
    public function getAllActiveAsync(): Builder;
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
    * @return Language
    */
    public function getPrimaryAsync(): Language
    {
        return
            parent::asyncExecution(function() {
                return parent::getAllAsync()->where('is_primary', 1)->first();
            });
    }
}
