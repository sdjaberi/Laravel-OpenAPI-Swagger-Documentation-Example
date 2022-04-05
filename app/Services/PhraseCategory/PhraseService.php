<?php

namespace App\Services\Phrase;

use App\Http\Exceptions\ApiUnAuthException;
use App\Models\Category;
use App\Services\Phrase\Models\PhraseFilter;
use App\Services\Phrase\Models\PhrasePageableFilter;
use App\Services\Phrase\Models\PhraseOut;
use App\Services\Base\Mapper;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PhraseRepository;
use Ramsey\Uuid\Type\Integer;
use stdClass;

interface IPhraseService
{
    /*
    public function getAllAsync();
    public function storeAsyncOrUpdate($id = null,$data);
    public function viewAsync($id);
    public function viewByEmail($id);
    public function deleteAsync($id);
    */

    public function getAll(PhrasePageableFilter $filter, array $include= []);
    public function getCount(PhrasePageableFilter $filter) : int;

    //public function refreshToken(RefreshTokenIn $model) : RefreshTokenOut;
    //public function me() : User;
    //public function logout();
    //public function register(RegisterIn $model) : LoginOut;

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
            $phraseDto = new PhraseOut($phrase);

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

    public function getCount(PhrasePageableFilter $filter) : int
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
        return User::find($id);
    }

    public function viewByEmail($email)
    {
        return User::find($email);
    }

    public function deleteAsync($id)
    {
        return User::find($id)->deleteAsync();
    }
}
