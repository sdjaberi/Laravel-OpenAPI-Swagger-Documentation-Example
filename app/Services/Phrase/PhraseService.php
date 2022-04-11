<?php

namespace App\Services\Phrase;

use App\Models\Phrase;
use App\Services\Phrase\Models\PhrasePageableFilter;
use App\Services\Phrase\Models\PhraseOut;
use App\Services\Category\Models\CategoryOut;
use App\Services\PhraseCategory\Models\PhraseCategoryOut;
use App\Services\Base\Mapper;
use App\Repositories\PhraseRepository;
use App\Services\Project\Models\ProjectOut;

interface IPhraseService
{
    public function getAll(PhrasePageableFilter $filter, array $include= []);
    public function getCount(PhrasePageableFilter $filter) : int;
}

class PhraseService implements IPhraseService
{
    private $_mapper;
    private $_phraseRepository;

    public function __construct(
        Mapper $mapper,
        PhraseRepository $phraseRepository
        )
    {
        $this->_mapper = $mapper;
        $this->_phraseRepository = $phraseRepository;
    }

    public function getAll(PhrasePageableFilter $filter, array $include = [])
    {
        $result = $this->_phraseRepository->getAllUserPhrasesAsync($filter, $include);

        $resultDto = $result->get()->map(function($phrase) {

            $phraseDto = new PhraseOut();

            $phraseDto = $this->_mapper->Map((object)$phrase->toArray(), $phraseDto);

            $categoryDto = new CategoryOut();

            $phraseDto->category = $this->_mapper->Map((object)$phrase->category->toArray(), $categoryDto);

            if(isset($phrase->category->project))
            {
                $projectDto = new ProjectOut();
                $phraseDto->category->project = $this->_mapper->Map((object)$phrase->category->project->toArray(), $projectDto);
            }

            if(isset($phrase->phraseCategory))
            {
                $phraseCategoryDto = new PhraseCategoryOut();
                $phraseDto->phraseCategory = $this->_mapper->Map((object)$phrase->phraseCategory->toArray(), $phraseCategoryDto);
            }

            return $phraseDto;
        });

        return $resultDto;
    }

    public function getCount(PhrasePageableFilter $filter) : int
    {
        $result = $this->_phraseRepository->count($filter);

        return $result;
    }

    public function viewAsync($id)
    {
        return Phrase::find($id);
    }

    public function viewByEmail($email)
    {
        return Phrase::find($email);
    }

    public function deleteAsync($id)
    {
        return Phrase::find($id)->deleteAsync();
    }
}
