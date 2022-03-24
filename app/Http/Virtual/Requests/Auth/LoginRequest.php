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
     *      title="username",
     *      description="Email of the user",
     *      example="admin@admin.admin"
     * )
     *
     * @var string
     */
    public $username;

    /**
     * @OA\Property(
     *      title="password",
     *      description="Password of the user",
     *      example="password"
     * )
     *
     * @var string
     */
    public $password;
}
