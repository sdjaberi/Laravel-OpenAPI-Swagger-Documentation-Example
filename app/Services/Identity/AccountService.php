<?php

namespace App\Services\Identity;

use App\Models\User;
use App\Services\Identity\Models\loginIn;
use App\Services\Identity\Models\loginOut;
use App\Services\Base\Mapper;

interface IAccountService
{
    /*
    public function getAllData();
    public function storeOrUpdate($id = null,$data);
    public function view($id);
    public function viewByEmail($id);
    public function delete($id);
    */

    public function login(loginIn $model) : loginOut;

    /*

    Task<loginOut> LoginViaOtpAsync(otpVerifyIn model);

    Task LogoutAsync();

    Task LogoutEverywhere();

    Task SendOtpAsync(string phoneNumber);

    Task<tokenOut> GetNewAccessTokenAsync();
    */

}

class AccountService implements IAccountService
{
    private $_mapper;

    public function __construct(Mapper $mapper)
    {
        $this->_mapper = $mapper;
    }

    public function login(loginIn $model) : loginOut
    {
        //$login = $_mapper->Map($model, new UserViewModel());
        $loginOut = $this->_mapper->Map($model, new loginOut());

        $credentials = (array) $model;

        if (!auth()->attempt($credentials)) {
            return response(['error_message' => 'Incorrect Details. Please try again'], 403);
        }

        //dd($loginOut);

        $currentUser =auth()->user();

        $loginOut->token = $currentUser->createToken('API Token')->accessToken;
        $loginOut->user = $currentUser;

        return $loginOut;
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
