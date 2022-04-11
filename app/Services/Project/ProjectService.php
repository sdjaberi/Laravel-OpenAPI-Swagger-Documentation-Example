<?php

namespace App\Services\Project;

use App\Models\Project;
use App\Services\Base\Mapper;
use App\Services\Project\Models\ProjectPageableFilter;
use App\Services\Project\Models\ProjectOut;
use App\Services\User\Models\UserOut;
use App\Services\Language\Models\LanguageOut;
use App\Repositories\ProjectRepository;
use App\Services\Category\Models\CategoryOut;

interface IProjectService
{
    public function getAll(ProjectPageableFilter $filter, array $include= []);
    public function getCount(ProjectPageableFilter $filter) : int;
}

class ProjectService implements IProjectService
{
    private $_mapper;
    private $_projectRepository;

    public function __construct(
        Mapper $mapper,
        ProjectRepository $projectRepository
        )
    {
        $this->_mapper = $mapper;
        $this->_projectRepository = $projectRepository;
    }

    public function getAll(ProjectPageableFilter $filter, array $include = [])
    {
        $result = $this->_projectRepository->getAllUserProjectsAsync($filter, $include);

        $resultDto = $result->get()->map(function($project) {

            $projectDto = new ProjectOut();

            $projectDto = $this->_mapper->Map((object)$project->toArray(), $projectDto);

            if(isset($project->author))
            {
                $userDto = new UserOut();

                $projectDto->user = $this->_mapper->Map((object)$project->author->toArray(), $userDto);
            }

            if(isset($project->languages))
            {
                $projectDto->languages = $project->languages->map(
                    function ($language) {
                        $languageDto = new LanguageOut();

                        $languageDto = $this->_mapper->Map((object)$language->toArray(), $languageDto);

                        return $languageDto;
                    }
                );
            }

            if(isset($project->categories))
            {
                $projectDto->categories = $project->categories->map(
                    function ($category) {
                        $categoryDto = new CategoryOut();

                        $categoryDto = $this->_mapper->Map((object)$category->toArray(), $categoryDto);

                        return $categoryDto;
                    }
                );
            }

            return $projectDto;
        });

        return $resultDto;
    }

    public function getCount(ProjectPageableFilter $filter) : int
    {
        $result = $this->_projectRepository->count($filter);

        return $result;
    }

    public function viewAsync($id)
    {
        return Project::find($id);
    }

    public function viewByEmail($email)
    {
        return Project::find($email);
    }

    public function deleteAsync($id)
    {
        return Project::find($id)->deleteAsync();
    }
}
