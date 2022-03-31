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
use Illuminate\Support\Facades\Gate;
use phpDocumentor\Reflection\Types\Boolean;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Laravel\Passport\Client as OClient;
use GuzzleHttp\Client;
use stdClass;

interface IAccountService
{
    /*
    public function getAllAsync();
    public function storeAsyncOrUpdate($id = null,$data);
    public function viewAsync($id);
    public function viewByEmail($id);
    public function deleteAsync($id);
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
    private $_userRepository;

    public function __construct(
        Mapper $mapper,
        RoleRepository $roleRepository,
        UserRepository $userRepository)
    {
        $this->_mapper = $mapper;
        $this->_roleRepository = $roleRepository;
        $this->_userRepository = $userRepository;
    }

    public function login(LoginIn $model) : LoginOut
    {
        $loginOut = $this->_mapper->Map($model, new LoginOut());

        $credentials = (array) $model;

        if (!Auth::attempt($credentials))
            throw new ApiUnAuthException();

        $user = Auth::user();

        $userPermissions = [];
        $userRoles = [];

        if (!app()->runningInConsole() && $user) {

            foreach ($user->roles as $role)
            {
                $rolepermissions = $role->permissions->map(fn($permission) => $permission->title);

                array_push($userRoles, $role->title);
                array_push($userPermissions, $rolepermissions);
            }

            $userPermissions = array_unique($userPermissions);
        }

        $oClient = OClient::where('password_client', 1)->first();

        $tokenResult = $this->getTokenAndRefreshToken($oClient, $model->email , $model->password, $userPermissions);

        $tokenResult = $tokenResult;

        $loginOut->accessToken = $tokenResult['access_token'];
        $loginOut->refreshToken = $tokenResult['refresh_token'];
        $loginOut->expires_in = $tokenResult['expires_in'];
        $loginOut->token_type = $tokenResult['token_type'];

        $userData = new stdClass();

        $userData->fullname = $user->name;
        $userData->email = $user->email;
        $userData->username = $user->email;
        $userData->id = $user->id;
        $userData->role = $userRoles[0];


        $userData->ability = $userPermissions[0]->map(function($permission) {

            $ability = new stdClass();
            $ability->action  = explode("_", $permission)[1];
            $ability->subject = explode("_", $permission)[0];

            return (object) $ability;
        });

        $loginOut->userData = $userData;

        return $loginOut;
    }

    public function getTokenAndRefreshToken(OClient $oClient, $email, $password, $userPermissions) {
        $oClient = OClient::where('password_client', 1)->first();
        $http = new Client;

        $response = $http->request('POST', env('APP_URL', 'http://localhost') . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $oClient->id,
                'client_secret' => $oClient->secret,
                'username' => $email,
                'password' => $password,
                'scope' => $userPermissions,
            ],
        ]);

        $result = json_decode((string) $response->getBody(), true);

        return $result;
        //return response()->json($result, $this->successStatus);
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
        //->updateAsync(['revoked', true]);

        //RefreshToken::whereIn('access_token_id', $tokens)->updateAsync(['revoked' => true]);

        return true;
    }



    public function register(RegisterIn $model) : LoginOut
    {
        $user = new User((array) $model);

        //$user = $this->_mapper->Map($model, $user);

        //dd($user);

        $user = $this->_userRepository->storeAsync($user);

        $tokenResult = $this->_userRepository->storeTokenAsync($user);

        $loginOut = $this->_mapper->Map($model, new LoginOut);
        $loginOut->user = $user;
        $loginOut->user_id = $user->id;
        $loginOut->token_id = $tokenResult->token->id;
        $loginOut->role = $user->roles;
        $loginOut->token = $tokenResult->accessToken;
        $loginOut->expires_at = $tokenResult->token->expires_at;
        $loginOut->token_type = 'Bearer';

        return $loginOut;
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
}
