<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Http\Exceptions\ApiNotFoundException;

interface IPermissionRepository
{
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
}

class PermissionRepository implements IPermissionRepository
{
    public function getAllData()
    {
        return Permission::latest()->get();
    }

    public function store($data)
    {
        $permission = new Permission();
        $permission->title = $data['title'];
        $permission->save();

        return $permission;
    }

    public function update($id = null, $data)
    {
        $permission = Permission::find($id);

        if(!$permission)
            throw new ApiNotFoundException();

        $permission->title = $data['title'];
        $permission->save();

        return $permission;
    }

    public function view($id)
    {
        return Permission::find($id);
    }

    public function delete($id)
    {
        return Permission::find($id)->delete();
    }

    public function deleteAll($ids)
    {
        return Permission::whereIn('id', $ids)->delete();
    }
}
