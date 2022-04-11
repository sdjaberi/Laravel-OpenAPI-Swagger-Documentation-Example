<?php

namespace App\Services\Language;

use App\Models\Language;
use App\Services\Language\Models\LanguagePageableFilter;
use App\Services\Language\Models\LanguageOut;
use App\Services\Base\Mapper;
use App\Repositories\LanguageRepository;

interface ILanguageService
{
    public function getAll(LanguagePageableFilter $filter, array $include= []);
    public function getCount(LanguagePageableFilter $filter) : int;
}

class LanguageService implements ILanguageService
{
    private $_mapper;
    private $_languageRepository;

    public function __construct(
        Mapper $mapper,
        LanguageRepository $languageRepository
        )
    {
        $this->_mapper = $mapper;
        $this->_languageRepository = $languageRepository;
    }

    public function getAll(LanguagePageableFilter $filter, array $include = [])
    {
        $result = $this->_languageRepository->getAllUserLanguagesAsync($filter, $include);

        $resultDto = $result->get()->map(function($language) {

            $languageDto = new LanguageOut();

            $languageDto = $this->_mapper->Map((object)$language->toArray(), $languageDto);

            return $languageDto;
        });

        return $resultDto;
    }

    public function getCount(LanguagePageableFilter $filter) : int
    {
        $result = $this->_languageRepository->count($filter, []);

        return $result;
    }

    public function viewAsync($id)
    {
        return Language::find($id);
    }

    public function viewByEmail($email)
    {
        return Language::find($email);
    }

    public function deleteAsync($id)
    {
        return Language::find($id)->deleteAsync();
    }
}
