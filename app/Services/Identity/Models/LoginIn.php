<?php

namespace App\Services\Identity\Models;

/**
 * @OA\Schema(
 *     title="LoginIn",
 *     description="LoginIn model",
 *     @OA\Xml(
 *         name="LoginIn"
 *     )
 * )
 */
class LoginIn
{
    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email",
     *     type="string",
     *     example="admin@admin.admin"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Password",
     *     description="Password",
     *     type="string",
     *     example="password"
     * )
     *
     * @var string
     */
    public $password;
}
