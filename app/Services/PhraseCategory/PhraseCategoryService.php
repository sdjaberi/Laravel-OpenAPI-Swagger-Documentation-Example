<?php

namespace App\Services\PhraseCategory;

use App\Models\PhraseCategory;
use App\Services\PhraseCategory\Models\PhraseCategoryPageableFilter;
use App\Services\PhraseCategory\Models\PhraseCategoryOut;
use App\Services\Base\Mapper;
use App\Repositories\PhraseCategoryRepository;
use App\Services\Project\Models\ProjectOut;
use Illuminate\Database\Eloquent\Builder;

interface IPhraseCategoryService
{
    public function getAll(PhraseCategoryPageableFilter $filter, array $include= []);
    public function getCount(PhraseCategoryPageableFilter $filter) : int;
}

class PhraseCategoryService implements IPhraseCategoryService
{
    private $_mapper;
    private $_phraseCategoryRepository;

    public function __construct(
        Mapper $mapper,
        PhraseCategoryRepository $phraseCategoryRepository
        )
    {
        $this->_mapper = $mapper;
        $this->_phraseCategoryRepository = $phraseCategoryRepository;
    }


    public function getAll(PhraseCategoryPageableFilter $filter, array $include = [])
    {
        $result = $this->_phraseCategoryRepository->getAllPhraseCategoriesAsync($filter, $include);

        $resultDto = $result->get()->map(function($phraseCategory) {

            $phraseCategoryDto = new PhraseCategoryOut();

            $phraseCategoryDto = $this->_mapper->Map((object)$phraseCategory->toArray(), $phraseCategoryDto);

            if(isset($phraseCategory->project))
            {
                $projectDto = new ProjectOut();
                $phraseCategoryDto->project = $this->_mapper->Map((object)$phraseCategory->project->toArray(), $projectDto);
            }

            return $phraseCategoryDto;
        });

        return $resultDto;
    }

    public function getCount(PhraseCategoryPageableFilter $filter) : int
    {
        $result = $this->_phraseCategoryRepository->getAllPhraseCategoriesAsync($filter);

        return $result->count();
    }

    public function viewAsync($id)
    {
        return PhraseCategory::find($id);
    }

    public function viewByEmail($email)
    {
        return PhraseCategory::find($email);
    }

    public function deleteAsync($id)
    {
        return PhraseCategory::find($id)->deleteAsync();
    }
}
