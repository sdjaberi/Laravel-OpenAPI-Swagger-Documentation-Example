<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Users\IndexUserRequest;
use App\Http\Requests\Web\Users\CreateUserRequest;
use App\Http\Requests\Web\Users\MassDestroyUserRequest;
use App\Http\Requests\Web\Users\StoreUserRequest;
use App\Http\Requests\Web\Users\UpdateUserRequest;
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
        $users = $this->_userRepository->getAllData();

        return view('admin.users.index', compact('users'));
    }

    public function create(CreateUserRequest $request)
    {
        $roles = $this->_roleRepository->getAllData()->pluck('title', 'id');
        $categories = $this->_categoryRepository->getAllData()->pluck('name', 'name');
        $languages = $this->_languageRepository->getAllData()->pluck('title', 'id');

        return view('admin.users.create', compact('roles','categories','languages'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->_userRepository->store($request);

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = $this->_roleRepository->getAllData()->pluck('title', 'id');
        $categories = $this->_categoryRepository->getAllData()->pluck('name', 'name');
        $languages = $this->_languageRepository->getAllData()->pluck('title', 'id');

        $user->load('roles', 'categories', 'languages');

        return view('admin.users.edit', compact('roles', 'categories', 'languages', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->_userRepository->update($user->id, $request);

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        $user = $this->_userRepository->view($user->id);

        $user->load('roles', 'languages','categories');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user = $this->_userRepository->delete($user->id);

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        $users = $this->_userRepository->deleteAll($request('ids'));

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
