<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Exceptions\ApiNotFoundException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

interface IUserRepository
{
    public function getAllAsync();
    public function storeAsync($data);
    public function updateAsync($id = null,$data);
    public function viewAsync($id);
    public function viewByEmail($id);
    public function deleteAsync($id);
    public function deleteAllAsync($ids);

    public function storeAsyncToken($data);
}

class UserRepository implements IUserRepository
{
    public function getAllAsync()
    {
        return User::latest()->get();
    }

    public function storeAsync($data)
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

    public function updateAsync($id = null, $data)
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

    public function viewAsync($id)
    {
        return User::find($id);
    }

    public function viewByEmail($email)
    {
        return User::find($email);
    }

    public function deleteAsync($id)
    {
        return User::find($id)->deleteAsync();
    }

    public function deleteAllAsync($ids)
    {
        return User::whereIn('id', $ids)->deleteAsync();
    }

    public function storeAsyncToken($user)
    {
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return $tokenResult;
    }

}
