<?php

namespace App\Repositories;

use App\Models\Role;
use App\Http\Exceptions\ApiNotFoundException;

interface IRoleRepository
{
    public function getAllAsync();
    public function storeAsync($data);
    public function updateAsync($id = null,$data);
    public function viewAsync($id);
    public function deleteAsync($id);
    public function deleteAllAsync($ids);
}

class RoleRepository implements IRoleRepository
{
    public function getAllAsync()
    {
        return Role::latest()->get();
    }

    public function storeAsync($data)
    {
        $role = new Role();
        $role->title = $data['title'];
        $role->save();

        $role->permissions()->sync($data['permissions']);

        return $role;
    }

    public function updateAsync($id = null, $data)
    {
        $role = Role::find($id);

        if(!$role)
            throw new ApiNotFoundException();

            $role->title = $data['title'];
        $role->save();

        $role->permissions()->sync($data['permissions']);

        return $role;
    }

    public function viewAsync($id)
    {
        return Role::find($id);
    }

    public function deleteAsync($id)
    {
        return Role::find($id)->deleteAsync();
    }

    public function deleteAllAsync($ids)
    {
        return Role::whereIn('id', $ids)->deleteAsync();
    }
}
