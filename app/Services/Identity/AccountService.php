<?php

namespace App\Services\Identity;

use App\Models\User;
use App\Services\Identity\Models\LoginIn;
use App\Services\Identity\Models\LoginOut;
use App\Services\Base\Mapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\RoleRepository;


interface IAccountService
{
    /*
    public function getAllData();
    public function storeOrUpdate($id = null,$data);
    public function view($id);
    public function viewByEmail($id);
    public function delete($id);
    */

    public function login(LoginIn $model) : LoginOut;
    public function me() : User;

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
    private $_roleRepository;

    public function __construct(Mapper $mapper, RoleRepository $roleRepository)
    {
        $this->_mapper = $mapper;
        $this->_roleRepository = $roleRepository;
    }

    public function login(LoginIn $model) : LoginOut
    {
        $loginOut = $this->_mapper->Map($model, new LoginOut());

        $credentials = (array) $model;

        if (!Auth::attempt($credentials)) {
            return response(['error_message' => 'Incorrect Details. Please try again'], 403);
        }

        $user = Auth::user();

        if (!app()->runningInConsole() && $user) {
            $roles            = $this->_roleRepository->getAllData();
            $permissionsArray = [];

            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }

            $userPermissions = array();

            foreach ($user->roles as $role)
                array_push($userPermissions, $role->permissions);

            $userPermissions = array_unique($userPermissions);
        }

        $tokenResult = $user->createToken('Personal Access Token', $userPermissions);
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        $loginOut->user = $user;
        $loginOut->id = $token->id;
        $loginOut->role = $user->roles;
        $loginOut->token = $tokenResult->accessToken;
        $loginOut->expires_at = $token->expires_at;
        $loginOut->token_type = 'Bearer';

        return $loginOut;
    }

    public function me() : User
    {
        $currentUser = Auth::user();

        if (!$currentUser)
            return response(['error_message' => 'Incorrect Details. Please try again'], 403);

        return $currentUser;
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
