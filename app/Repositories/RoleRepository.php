<?php

namespace App\Repositories;

use App\Models\Role;
use App\Http\Exceptions\ApiNotFoundException;

interface IRoleRepository
{
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function view($id);
    public function delete($id);
    public function deleteAll($ids);
}

class RoleRepository implements IRoleRepository
{
    public function getAllData()
    {
        return Role::latest()->get();
    }

    public function store($data)
    {
        $role = new Role();
        $role->title = $data['title'];
        $role->save();

        $role->permissions()->sync($data['permissions']);

        return $role;
    }

    public function update($id = null, $data)
    {
        $role = Role::find($id);

        if(!$role)
            throw new ApiNotFoundException();

            $role->title = $data['title'];
        $role->save();

        $role->permissions()->sync($data['permissions']);

        return $role;
    }

    public function view($id)
    {
        return Role::find($id);
    }

    public function delete($id)
    {
        return Role::find($id)->delete();
    }

    public function deleteAll($ids)
    {
        return Role::whereIn('id', $ids)->delete();
    }
}
