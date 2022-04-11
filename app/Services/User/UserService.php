<?php

namespace App\Services\User;

use App\Models\User;
use App\Services\User\Models\UserPageableFilter;
use App\Services\User\Models\UserOut;
use App\Services\Category\Models\CategoryOut;
use App\Services\UserCategory\Models\UserCategoryOut;
use App\Services\Base\Mapper;
use App\Repositories\UserRepository;
use App\Services\Project\Models\ProjectOut;

interface IUserService
{
    public function getAll(UserPageableFilter $filter, array $include= []);
    public function getCount(UserPageableFilter $filter) : int;
}

class UserService implements IUserService
{
    private $_mapper;
    private $_phraseRepository;

    public function __construct(
        Mapper $mapper,
        UserRepository $phraseRepository
        )
    {
        $this->_mapper = $mapper;
        $this->_phraseRepository = $phraseRepository;
    }

    public function getAll(UserPageableFilter $filter, array $include = [])
    {
        $result = $this->_phraseRepository->getAllUserUsersAsync($filter, $include);

        $resultDto = $result->get()->map(function($phrase) {

            $phraseDto = new UserOut();

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
                $phraseCategoryDto = new UserCategoryOut();
                $phraseDto->phraseCategory = $this->_mapper->Map((object)$phrase->phraseCategory->toArray(), $phraseCategoryDto);
            }

            return $phraseDto;
        });

        return $resultDto;
    }

    public function getCount(UserPageableFilter $filter) : int
    {
        $result = $this->_phraseRepository->getAllUserUsersAsync($filter);

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
