<?php

namespace App\Services\Category;

use App\Http\Exceptions\ApiUnAuthException;
use App\Models\Category;
use App\Services\Category\Models\CategoryFilter;
use App\Services\Category\Models\CategoryPageableFilter;
use App\Services\Category\Models\CategoryOut;
use App\Services\Base\Mapper;
use App\Repositories\CategoryRepository;

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
        $result = $this->_categoryRepository->getAllAsync($filter, $include);

        if(isset($filter->phrase))
        {
            $result = $result
                ->where('phrase', 'like', '%' .$filter->phrase. '%');
        }

        if(isset($filter->category))
        {
            //dd($filter->category);
            $result = $result
                ->join('categories', 'phrases.category_name', '=', 'categories.name')
                ->select('categories.name', 'phrases.*')
                ->where('categories.name' , 'like', '%' .$filter->category. '%');
        }

        if(isset($filter->phraseCategory))
        {
            $result = $result
                ->join('phrase_categories', 'phrases.phrase_category_id', '=', 'phrase_categories.id')
                ->select('phrase_categories.name', 'phrases.*')
                ->where('phrase_categories.name' , 'like', '%' .$filter->phraseCategory. '%');
        }

        $resultDto = $result->get()->map(function($phrase) {

            //dd($phrase);
            $phraseDto = new CategoryOut($phrase);

            //dd($phrase->toArray());

            $phraseDto = $this->_mapper->Map((object)$phrase->toArray(), $phraseDto);

            $categoryDto = new CategoryOut();

            $phraseDto->category = $this->_mapper->Map((object)$phrase->category->toArray(), $categoryDto);

            dd($phraseDto->category);

            /*
            $phraseDto->category  = $phrase->id;
            $phraseDto->base_id  = $phrase->base_id;
            $phraseDto->phrase  = $phrase->phrase;
            $phraseDto->category_name  = $phrase->category_name;
            $phraseDto->phrase_category_id  = $phrase->phrase_category_id;
            $phraseDto->phrase_category_name  = $phrase->name;
            $phraseDto->created_at  = $phrase->created_at;
            */

            return $phraseDto;
        });

        return $resultDto;
    }

    public function getCount(CategoryPageableFilter $filter) : int
    {
        $result = $this->_phraseRepository->getAllAsync();

        if(isset($filter->phrase))
        {
            $result = $result
                ->where('phrase', 'like', '%' .$filter->phrase. '%');
        }

        if(isset($filter->category))
        {
            //dd($filter->category);
            $result = $result
                ->join('categories', 'phrases.category_name', '=', 'categories.name')
                ->select('categories.name', 'phrases.*')
                ->where('categories.name' , 'like', '%' .$filter->category. '%');
        }

        if(isset($filter->phraseCategory))
        {
            $result = $result
                ->join('phrase_categories', 'phrases.phrase_category_id', '=', 'phrase_categories.id')
                ->select('phrase_categories.name', 'phrases.*')
                ->where('phrase_categories.name' , 'like', '%' .$filter->phraseCategory. '%');
        }

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
