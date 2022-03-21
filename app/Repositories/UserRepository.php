<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Exceptions\ApiNotFoundException;

interface IUserRepository
{
    public function getAllData();
    public function store($data);
    public function update($id = null,$data);
    public function view($id);
    public function viewByEmail($id);
    public function delete($id);
    public function deleteAll($ids);
}

class UserRepository implements IUserRepository
{
    public function getAllData()
    {
        return User::latest()->get();
    }

    public function store($data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();

        $user->roles()->sync($data['roles']);
        $user->languages()->sync($data['languages']);
        $user->categories()->sync($data['categories']);

        return $user;
    }

    public function update($id = null, $data)
    {
        $user = User::find($id);

        if(!$user)
            throw new ApiNotFoundException();

        $user->name = $data['name'];
        $user->email = $data['email'];

        if(strlen(trim($data['password'])) > 0)
            $user->password = bcrypt($data['password']);

        $user->save();

        $user->roles()->sync($data['roles']);
        $user->languages()->sync($data['languages']);
        $user->categories()->sync($data['categories']);

        return $user;
    }

    public function view($id)
    {
        return User::find($id);
    }

    public function viewByEmail($email)
    {
        return User::find($email);
    }

    public function delete($id)
    {
        return User::find($id)->delete();
    }

    public function deleteAll($ids)
    {
        return User::whereIn('id', $ids)->delete();
    }
}
