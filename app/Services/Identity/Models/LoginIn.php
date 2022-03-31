<?php

namespace App\Services\Identity\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="LoginIn",
 *     description="LoginIn model",
 *     @OA\Xml(
 *         name="LoginIn"
 *     )
 * )
 */
class LoginIn extends IDto
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
