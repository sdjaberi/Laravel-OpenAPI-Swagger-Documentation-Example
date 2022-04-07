<?php

namespace App\Services\Category;

use App\Models\Category;
use App\Services\Category\Models\CategoryPageableFilter;
use App\Services\Category\Models\CategoryOut;
use App\Services\CategoryCategory\Models\CategoryCategoryOut;
use App\Services\Base\Mapper;
use App\Repositories\CategoryRepository;
use App\Services\Project\Models\ProjectOut;
use Illuminate\Database\Eloquent\Builder;

interface ICategoryService
{
    public function getAll(CategoryPageableFilter $filter, array $include= []);
    public function getCount(CategoryPageableFilter $filter) : int;
}

class CategoryService implements ICategoryService
{
    private $_mapper;
    private $_categoryRepository;

    public function __construct(
        Mapper $mapper,
        CategoryRepository $categoryRepository
        )
    {
        $this->_mapper = $mapper;
        $this->_categoryRepository = $categoryRepository;
    }

    public function filter(Builder $result, CategoryPageableFilter $filter)
    {
        if(isset($filter->category))
        {
            $result = $result
                ->where('name', '=', $filter->category);
        }

        if(isset($filter->project))
        {
            $result = $result
                ->join('projects', 'categories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'categories.*')
                ->where('projects.name' , '=', $filter->project);
        }

        if(isset($filter->q))
        {
            $result = $result
                ->where('categories.name', 'like', '%' .$filter->q. '%')

                ->join('projects', 'categories.project_id', '=', 'projects.id')
                ->select('projects.name as projectName', 'categories.*')
                ->orWhere('projects.name' , 'like', '%' .$filter->q. '%');;
        }

        return $result;
    }


    public function getAll(CategoryPageableFilter $filter, array $include = [])
    {
        $result = $this->_categoryRepository->getAllAsync($filter, $include)->withCount('phrases');

        $result = $this->filter($result, $filter);

        $resultDto = $result->get()->map(function($category) {

            $categoryDto = new CategoryOut();

            $categoryDto = $this->_mapper->Map((object)$category->toArray(), $categoryDto);

            if(isset($category->project))
            {
                $projectDto = new ProjectOut();
                $categoryDto->project = $this->_mapper->Map((object)$category->project->toArray(), $projectDto);
            }

            return $categoryDto;
        });

        return $resultDto;
    }

    public function getCount(CategoryPageableFilter $filter) : int
    {
        $result = $this->_categoryRepository->getAllAsync();

        $result = $this->filter($result, $filter);

        return $result->count();
    }

    public function viewAsync($id)
    {
        return Category::find($id);
    }

    public function viewByEmail($email)
    {
        return Category::find($email);
    }

    public function deleteAsync($id)
    {
        return Category::find($id)->deleteAsync();
    }
}
