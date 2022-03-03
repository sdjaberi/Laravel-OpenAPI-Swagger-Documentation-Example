<?php

namespace App\Http\Virtual\Requests\Auth;

/**
 * @OA\Schema(
 *      title="Auth register request",
 *      description="Auth register request body data",
 *      type="object",
 *      required={"name", "email" ,"password"}
 * )
 */

class RegisterRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the user",
     *      example="john legend"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="email",
     *      description="Email of the user",
     *      example="example/\@\example.example"
     * )
     *
     * @var string
     */
    public $email;

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
