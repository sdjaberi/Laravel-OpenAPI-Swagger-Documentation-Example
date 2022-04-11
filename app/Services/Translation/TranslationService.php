<?php

namespace App\Services\Translation;

use App\Models\Translation;
use App\Services\Translation\Models\TranslationPageableFilter;
use App\Services\Translation\Models\TranslationOut;
use App\Services\Phrase\Models\PhraseOut;
use App\Services\Language\Models\LanguageOut;
use App\Services\User\Models\UserOut;
use App\Services\Base\Mapper;
use App\Repositories\TranslationRepository;

interface ITranslationService
{
    public function getAll(TranslationPageableFilter $filter, array $include= []);
    public function getCount(TranslationPageableFilter $filter) : int;
}

class TranslationService implements ITranslationService
{
    private $_mapper;
    private $_translationRepository;

    public function __construct(
        Mapper $mapper,
        TranslationRepository $translationRepository
        )
    {
        $this->_mapper = $mapper;
        $this->_translationRepository = $translationRepository;
    }

    public function getAll(TranslationPageableFilter $filter, array $include = [])
    {
        $result = $this->_translationRepository->getAllUserTranslationsAsync($filter, $include);

        $resultDto = $result->get()->map(function($translation) {

            $translationDto = new TranslationOut();

            $translationDto = $this->_mapper->Map((object)$translation->toArray(), $translationDto);

            $phraseDto = new PhraseOut();

            $translationDto->phrase = $this->_mapper->Map((object)$translation->phrase->toArray(), $phraseDto);

            $languageDto = new LanguageOut();

            $translationDto->language = $this->_mapper->Map((object)$translation->language->toArray(), $languageDto);

            if(isset($translation->user))
            {
                $userDto = new UserOut();
                $translationDto->user = $this->_mapper->Map((object)$translation->user->toArray(), $userDto);
            }

            return $translationDto;
        });

        return $resultDto;
    }

    public function getCount(TranslationPageableFilter $filter) : int
    {
        $result = $this->_translationRepository->count($filter);

        return $result;
    }

    public function viewAsync($id)
    {
        return Translation::find($id);
    }

    public function viewByEmail($email)
    {
        return Translation::find($email);
    }

    public function deleteAsync($id)
    {
        return Translation::find($id)->deleteAsync();
    }
}
