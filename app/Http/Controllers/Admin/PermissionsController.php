<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Permissions\IndexPermissionRequest;
use App\Http\Requests\Permissions\CreatePermissionRequest;
use App\Http\Requests\Permissions\MassDestroyPermissionRequest;
use App\Http\Requests\Permissions\StorePermissionRequest;
use App\Http\Requests\Permissions\UpdatePermissionRequest;
use App\Models\Permission;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\PermissionRepository;

class PermissionsController extends Controller
{
    private $_permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->_permissionRepository = $permissionRepository;
    }

    public function index(IndexPermissionRequest $request)
    {
        $permissions = $this->_permissionRepository->getAllData();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create(CreatePermissionRequest $request)
    {
        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = $this->_permissionRepository->store($request);

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $permission = $this->_permissionRepository->update($permission->id, $request);

        return redirect()->route('admin.permissions.index');
    }

    public function show(Permission $permission)
    {
        $permission = $this->_permissionRepository->view($permission->id);

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(Permission $permission)
    {
        $permission = $this->_permissionRepository->delete($permission->id);

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        $permissions = $this->_permissionRepository->deleteAll($request('ids'));

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
