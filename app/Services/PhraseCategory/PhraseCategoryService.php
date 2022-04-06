<?php

namespace App\Services\Phrase;

use App\Models\PhraseCategory;
use App\Services\PhraseCategory\Models\PhraseCategoryFilter;
use App\Services\PhraseCategory\Models\PhraseCategoryPageableFilter;
use App\Services\PhraseCategory\Models\PhraseCategoryOut;
use App\Services\Base\Mapper;
use App\Repositories\PhraseCategoryRepository;

interface IPhraseCategoryService
{
    public function getAll(PhraseCategoryPageableFilter $filter, array $include= []);
    public function getCount(PhraseCategoryPageableFilter $filter) : int;
    /*
        IEnumerable<botOut> GetAll(botPageableFilter filter);

        int Count(botFilter filter);

        Task<botOut> GetByIdAsync(int id);

        Task<botOut> CreateAsync(botIn model);

        Task<botOut> UpdateAsync(int id, botIn model);

        Task DeleteAsync(int id);

        Task PauseAsync(int id);

        Task ResumeAsync(int id);
    */

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
        $result = $this->_phraseRepository->getAllAsync($filter, $include);

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

        /*
        foreach ($includeSearch as $key => $search) {
            # code...
            $table = explode(".", $search)[0];
            $column = explode(".", $search)[1];

            $valueCol = $include[$key];

            $query = $query
            ->join($table, $this->model->getTable().'.'.$include[$key].'_'.$column, '=', $table.'.'.$column)
            ->select($table.'.*', $this->model->getTable().'.*')
            ->orWhere($table.'.'.$column, 'like', '%' .$filter->$valueCol. '%');

            //dd($table.'.'.$column);
        }
        */

        $resultDto = $result->get()->map(function($phrase) {

            //dd($phrase);
            $phraseDto = new PhraseCategoryOut($phrase);

            //dd($phrase->toArray());

            $phraseDto = $this->_mapper->Map((object)$phrase->toArray(), $phraseDto);

            $categoryDto = new PhraseCategoryOut();

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

    public function getCount(PhraseCategoryPageableFilter $filter) : int
    {
        $result = $this->_phraseCategoryRepository->getAllAsync();

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
