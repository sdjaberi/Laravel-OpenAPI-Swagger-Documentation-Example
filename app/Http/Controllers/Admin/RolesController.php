<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Roles\IndexRoleRequest;
use App\Http\Requests\Web\Roles\StoreRoleRequest;
use App\Http\Requests\Web\Roles\UpdateRoleRequest;
use App\Http\Requests\Web\Roles\ShowRoleRequest;
use App\Http\Requests\Web\Roles\DeleteRoleRequest;
use App\Http\Requests\Web\Roles\MassDestroyRoleRequest;
use App\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;

class RolesController extends Controller
{
    private $_roleRepository;
    private $_permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->_roleRepository = $roleRepository;
        $this->_permissionRepository = $permissionRepository;
    }

    public function index(IndexRoleRequest $request)
    {
        $roles = $this->_roleRepository->getAllAsync();

        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->_permissionRepository->getAllAsync()->pluck('title', 'id');

        return view('admin.roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $this->_roleRepository->storeAsync($request->all(), ['permissions']);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = $this->_permissionRepository->getAllAsync()->pluck('title', 'id');

        $role->load('permissions');

        return view('admin.roles.edit', compact('permissions', 'role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role = $this->_roleRepository->updateAsync($role->id, $request->all(), ['permissions']);

        return redirect()->route('admin.roles.index');
    }

    public function show(ShowRoleRequest $request, Role $role)
    {
        $role = $this->_roleRepository->viewAsync($role->id);

        //$role->load('permissions','rolesUsers');

        return view('admin.roles.show', compact('role'));
    }

    public function destroy(DeleteRoleRequest $request, Role $role)
    {
        $role = $this->_roleRepository->deleteAsync($role->id);

        return back();
    }

    public function massDestroy(MassDestroyRoleRequest $request)
    {
        $roles = $this->_roleRepository->deleteAllAsync($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
