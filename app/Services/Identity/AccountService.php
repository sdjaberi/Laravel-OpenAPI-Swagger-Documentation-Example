<?php

namespace App\Services\Identity;

use App\Http\Exceptions\ApiUnAuthException;
use App\Models\User;
use App\Services\Identity\Models\LoginIn;
use App\Services\Identity\Models\LoginOut;
use App\Services\Identity\Models\RegisterIn;

use App\Services\Base\Mapper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Boolean;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

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
    public function logout();
    public function register(RegisterIn $model) : LoginOut;


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
            throw new ApiUnAuthException();
        }

        $user = Auth::user();

        $userPermissions = [];

        if (!app()->runningInConsole() && $user) {

            foreach ($user->roles as $role)
            {
                $rolepermissions = $role->permissions->map(fn($permission) => $permission->title);

                array_push($userPermissions, $rolepermissions);
            }

            $userPermissions = array_unique($userPermissions);
        }

        $tokenResult = $user->createToken('Personal Access Token', $userPermissions[0]->toArray());

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

        return $currentUser;
    }

    public function logout()
    {
        $currentUser = $this->me();

        if (!$token = $currentUser->token()) {
            throw new ApiUnAuthException();
        }

        $token->revoke();

        //$tokens =  $user->tokens->pluck('id');
        //Token::whereIn('id', $tokens)
        //->update(['revoked', true]);

        //RefreshToken::whereIn('access_token_id', $tokens)->update(['revoked' => true]);

        return true;
    }



    public function register(RegisterIn $model) : LoginOut
    {
        $loginOut = $this->_mapper->Map($model, new LoginOut());

        //dd($model);

        $user = new User();
        $user->name = $model->name;
        $user->email = $model->email;
        $user->password = bcrypt($model->password);

        $user->save();

        $tokenResult = $user->createToken('Personal Access Token');

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
