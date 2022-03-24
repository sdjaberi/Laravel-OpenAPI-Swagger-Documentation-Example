<?php

namespace App\Http\Virtual\Requests\Auth;

/**
 * @OA\Schema(
 *      title="Auth Login request",
 *      description="Auth Login request body data",
 *      type="object",
 *      required={"email","password"}
 * )
 */

class LoginRequest
{
    /**
     * @OA\Property(
     *      title="email",
     *      description="Email of the user",
     *      example="example(at)example.example"
     * )
     *
     * @var string
     */
    public $username;

    /**
     * @OA\Property(
     *      title="password",
     *      description="Password of the user",
     *      example="this is a user password"
     * )
     *
     * @var string
     */
    public $password;
}
