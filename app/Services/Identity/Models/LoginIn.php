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
     *     example="example@example.com"
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
     *     example="j#dH5iJ3@"
     * )
     *
     * @var string
     */
    public $password;
}
