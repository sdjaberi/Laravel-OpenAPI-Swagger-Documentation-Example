<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Users\IndexUserRequest;
use App\Http\Requests\Web\Users\StoreUserRequest;
use App\Http\Requests\Web\Users\UpdateUserRequest;
use App\Http\Requests\Web\Users\ShowUserRequest;
use App\Http\Requests\Web\Users\DeleteUserRequest;
use App\Http\Requests\Web\Users\MassDestroyUserRequest;
use App\Http\Requests\Web\Users\UpdateUserAjaxRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\UserRepository;


class UsersController extends Controller
{
    private $_userRepository;

    public function __construct(
        UserRepository $userRepository
        )
    {
        $this->_userRepository = $userRepository;
    }

    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles'])->get());
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->updateAsync($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->deleteAsync();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
