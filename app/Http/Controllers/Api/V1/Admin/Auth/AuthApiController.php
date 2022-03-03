<?php

namespace App\Http\Controllers\Api\V1\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\Identity\Models\loginIn;
use App\Services\Identity\Models\loginOut;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\Identity\AccountService;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Base\Mapper;

class AuthApiController extends Controller
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
     *      tags={"Auth"},
     *      summary="Get a JWT via given credentials",
     *      description="Returns bearer string token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Requests/Auth/LoginRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Auth")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function login(LoginRequest $request)
    {
        //$request->all();

        //$login = this->_mapper->Map($request->all(), new UserViewModel());

        dd($request);

        $loginIn = new loginIn;
        $loginIn->email = $request['email'];
        $loginIn->password = $request['password'];

        $result = $this->_accountService->login($loginIn);

        return response([$result,'message' => 'Login Successful!']);
    }

    /**
     * @OA\Get(
     *      path="/me",
     *      operationId="LogedInUser",
     *      tags={"Auth"},
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
        dd(auth()->user());
        if (!$user = auth()->user()) {
            return response(['error_message' => 'Incorrect Details. Please try again'], 401);
        }

        $token = auth()->login($user);

        return response()->json(['user' => $user, 'token' => $token, 'message' => 'Logged in user Return!']);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

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
     *      tags={"Auth"},
     *      summary="Register new user",
     *      description="Returns user data",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/requests/auth/RegisterRequest")
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
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $this->_userRepository->storeOrUpdate(null, $request->all());

        $user = $this->_userRepository->viewByEmail($request->email);

        $token = $user->createToken('API Token')->accessToken;

        return response()->json(['user' => $user, 'token' => $token, 'message' => 'Registration Successful!']);
    }
}
