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

    public function filter(Builder $result, PhraseCategoryPageableFilter $filter)
    {
        if(isset($filter->phraseCategory))
        {
            $result = $result
                ->where('name', '=', $filter->phraseCategory);
        }

        if(isset($filter->project))
        {
            $result = $result
                ->join('projects', 'phraseCategories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'phraseCategories.*')
                ->where('projects.name' , '=', $filter->project);
        }

        if(isset($filter->q))
        {
            $result = $result
                ->where('phraseCategories.name', 'like', '%' .$filter->q. '%')

                ->join('projects', 'phraseCategories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'phraseCategories.*')
                ->orWhere('projects.name' , 'like', '%' .$filter->q. '%');;
        }

        return $result;
    }

    public function getAll(PhraseCategoryPageableFilter $filter, array $include = [])
    {
        $result = $this->_phraseCategoryRepository->getAllAsync($filter, $include)->withCount('phrases');

        $result = $this->filter($result, $filter);

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
        $result = $this->_phraseCategoryRepository->getAllAsync();

        $result = $this->filter($result, $filter);

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
