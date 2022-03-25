<?php

namespace App\Services\Identity\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="RegisterIn",
 *     description="RegisterIn model",
 *     @OA\Xml(
 *         name="RegisterIn"
 *     )
 * )
 */
class RegisterIn extends IDto
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name",
     *     example="john legend"
     * )
     *
     * @var string
     */
    public $name;

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
