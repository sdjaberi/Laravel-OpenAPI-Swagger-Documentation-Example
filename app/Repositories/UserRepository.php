<?php

namespace App\Repositories;

use App\Models\User;

interface IUserRepository
{
    public function getAllData();
    public function storeOrUpdate($id = null,$data);
    public function view($id);
    public function viewByEmail($id);
    public function delete($id);
}

class UserRepository implements IUserRepository
{
    public function getAllData()
    {
        return User::latest()->get();
    }

    public function storeOrUpdate($id = null,$data)
    {
        if(is_null($id))
        {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);

            return $user->save();
        }
        else
        {
            $user = User::find($id);
            $user->name = $data['name'];
            $user->password = bcrypt($data['password']);

            return $user->save();
        }
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
}
