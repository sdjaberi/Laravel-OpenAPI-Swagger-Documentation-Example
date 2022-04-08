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

    public function getAll(CategoryPageableFilter $filter, array $include = [])
    {
        $result = $this->_categoryRepository->getAllUserCategoriesAsync($filter, $include);

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
        $result = $this->_categoryRepository->getAllUserCategoriesAsync($filter);

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
