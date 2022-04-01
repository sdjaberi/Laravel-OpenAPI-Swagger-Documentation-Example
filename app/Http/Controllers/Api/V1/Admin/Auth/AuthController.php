<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Identity\Models\LoginIn;
use App\Services\Identity\Models\RefreshTokenIn;
use App\Services\Identity\Models\RegisterIn;

use App\Repositories\UserRepository;
use App\Services\Identity\AccountService;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RefreshTokenRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Services\Base\Mapper;

class AuthController extends Controller
{
    private $_userRepository;
    private $_accountService;
    private $_mapper;

    public function __construct(
        UserRepository $userRepository,
        AccountService $accountService,

        Mapper $mapper)
    {
        $this->_userRepository = $userRepository;
        $this->_accountService = $accountService;
        $this->_mapper = $mapper;
    }

     /**
     * @OA\Post(
     *      path="/login",
     *      operationId="getJwtToken",
     *      tags={"Account"},
     *      summary="Get a JWT via given credentials",
     *      description="Returns bearer string token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginIn")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Auth")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(ref="#/components/schemas/ApiRequestException")
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/ApiAccessDeniedException")
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnprocessableEntityException")
     *      ),
     * )
     */

    public function login(LoginRequest $request)
    {
        $request->validated();

        $loginIn = new LoginIn;
        $loginIn->email = $request['email'];
        $loginIn->password = $request['password'];

        $result = $this->_accountService->login($loginIn);

        return response(['result' => $result ,'message' => 'Login Successful!']);
    }

    /**
     * @OA\Post(
     *      path="/refreshToken",
     *      operationId="getJwtToken by a valid refresh token",
     *      tags={"Account"},
     *      summary="Get a JWT via given credentials by a valid refresh token",
     *      description="Returns bearer string token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RefreshTokenIn")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Auth")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request",
     *          @OA\JsonContent(ref="#/components/schemas/ApiRequestException")
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *          @OA\JsonContent(ref="#/components/schemas/ApiAccessDeniedException")
     *      ),
     *      @OA\Response(
     *          response="422",
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(ref="#/components/schemas/ApiUnprocessableEntityException")
     *      ),
     * )
     */

    public function refreshToken(RefreshTokenRequest $request)
    {
        $request->validated();

        $refreshTokenIn = new RefreshTokenIn;
        $refreshTokenIn->refreshToken = $request['refreshToken'];

        $result = $this->_accountService->refreshToken($refreshTokenIn);

        //dd($result);


        return response(['result' => $result ,'message' => 'Login Successful!']);
    }

    /**
     * @OA\Get(
     *      path="/me",
     *      operationId="LogedInUser",
     *      security={{"passport": {}}},
     *      tags={"Account"},
     *      summary="Get the logged in user information",
     *      description="Returns user data",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function me()
    {
        $result = $this->_accountService->me();

        if (!$result )
            return response(['error_message' => 'Incorrect Details. Please try again'], 401);

        return response([$result, 'message' => 'Logged in user Return!']);
    }


    /**
     * @OA\Get(
     *      path="/logout",
     *      operationId="LogoutUser",
     *      security={{"passport": {}}},
     *      tags={"Account"},
     *      summary="Get Logout user",
     *      description="Return message",
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      )
     * )
     */
    public function logout()
    {
        $result = $this->_accountService->logout();

        if (!$result )
            return response(['error_message' => 'Incorrect Details. Please try again'], 401);

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
    */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }



    /**
     * @OA\Post(
     *      path="/register",
     *      operationId="registerUser",
     *      tags={"Users"},
     *      summary="Register new user",
     *      description="Returns user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RegisterIn")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function register(RegisterRequest $request)
    {
        $request->validated();

        $registerUser = new RegisterIn;
        $registerUser->name = $request['name'];
        $registerUser->email = $request['email'];
        $registerUser->password = $request['password'];

        $result = $this->_accountService->register($registerUser);

        return response([$result, 'message' => 'Registration Successful!']);
    }

}
