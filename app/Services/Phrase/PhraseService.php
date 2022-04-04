<?php

namespace App\Services\Phrase;

use App\Http\Exceptions\ApiUnAuthException;
use App\Services\Phrase\Models\PhraseFilter;
use App\Services\Phrase\Models\PhrasePageableFilter;
use App\Services\Phrase\Models\PhraseOut;
use App\Services\Base\Mapper;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PhraseRepository;
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
        $result = $this->_phraseRepository->getAllAsync($filter, $include)->get();

        $resultDto = $result->map(function($phrase) {

            $phraseDto = new stdClass();
            $phraseDto->id  = $phrase->id;
            $phraseDto->base_id  = $phrase->base_id;
            $phraseDto->phrase  = $phrase->phrase;
            $phraseDto->category_name  = $phrase->category_name;
            $phraseDto->phrase_category_id  = $phrase->phrase_category_id;

            return (object) $phraseDto;
        });

        return $resultDto;
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
