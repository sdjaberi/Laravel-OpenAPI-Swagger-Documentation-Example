<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Users\IndexUserRequest;
use App\Http\Requests\Web\Users\StoreUserRequest;
use App\Http\Requests\Web\Users\UpdateUserRequest;
use App\Http\Requests\Web\Users\ShowUserRequest;
use App\Http\Requests\Web\Users\DeleteUserRequest;
use App\Http\Requests\Web\Users\MassDestroyUserRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\LanguageRepository;

class UsersController extends Controller
{
    private $_userRepository;
    private $_roleRepository;
    private $_categoryRepository;
    private $_languageRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        CategoryRepository $categoryRepository,
        LanguageRepository $languageRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_roleRepository = $roleRepository;
        $this->_categoryRepository = $categoryRepository;
        $this->_languageRepository = $languageRepository;
    }

    public function index(IndexUserRequest $request)
    {
        $users = $this->_userRepository->getAllAsync();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = $this->_roleRepository->getAllAsync()->pluck('title', 'id');
        $categories = $this->_categoryRepository->getAllAsync()->pluck('name', 'name');
        $languages = $this->_languageRepository->getAllAsync()->pluck('title', 'id');

        return view('admin.users.create', compact('roles','categories','languages'));
    }

    public function store(StoreUserRequest $request)
    {
    //$user->password = bcrypt($data['password']);
        $attributes = $request->all();
        $attributes['password'] = bcrypt($attributes['password']);

        $user = $this->_userRepository->storeAsync($attributes, ['roles','categories','languages']);

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = $this->_roleRepository->getAllAsync()->pluck('title', 'id');
        $categories = $this->_categoryRepository->getAllAsync()->pluck('name', 'name');
        $languages = $this->_languageRepository->getAllAsync()->pluck('title', 'id');

        $user->load('roles', 'categories', 'languages');

        return view('admin.users.edit', compact('roles', 'categories', 'languages', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $attributes = $request->all();
        if(strlen(trim($attributes['password'])) > 0)
            $attributes['password'] = bcrypt($attributes['password']);

        $user = $this->_userRepository->updateAsync($user->id, $attributes, ['roles','categories','languages']);

        return redirect()->route('admin.users.index');
    }

    public function show(ShowUserRequest $request, User $user)
    {
        $user = $this->_userRepository->viewAsync($user->id);

        $user->load('roles', 'languages','categories');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(DeleteUserRequest $request, User $user)
    {
        $result = $this->_userRepository->deleteAsync($user->id);

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $result = $this->_userRepository->deleteAllAsync($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
