<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Permissions\IndexPermissionRequest;
use App\Http\Requests\Web\Permissions\StorePermissionRequest;
use App\Http\Requests\Web\Permissions\UpdatePermissionRequest;
use App\Http\Requests\Web\Permissions\ShowPermissionRequest;
use App\Http\Requests\Web\Permissions\MassDestroyPermissionRequest;
use App\Http\Requests\Web\Permissions\DeletePermissionRequest;
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
        $permissions = $this->_permissionRepository->getAllAsync();

        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $permission = $this->_permissionRepository->storeAsync($request->all());

        return redirect()->route('admin.permissions.index');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $result = $this->_permissionRepository->updateAsync($permission->id, $request->all());

        return redirect()->route('admin.permissions.index');
    }

    public function show(ShowPermissionRequest $request, Permission $permission)
    {
        $permission = $this->_permissionRepository->viewAsync($permission->id);

        return view('admin.permissions.show', compact('permission'));
    }

    public function destroy(DeletePermissionRequest $request, Permission $permission)
    {
        $result = $this->_permissionRepository->deleteAsync($permission->id);

        return back();
    }

    public function massDestroy(MassDestroyPermissionRequest $request)
    {
        $result = $this->_permissionRepository->deleteAllAsync($request->ids);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
