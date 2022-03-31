<?php

namespace App\Services\Identity\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="LoginOut",
 *     description="LoginOut model",
 *     @OA\Xml(
 *         name="LoginOut"
 *     )
 * )
 */
class LoginOut extends IDto
{
    /**
     * @OA\Property(
     *      title="Token",
     *      description="A JWT token",
     *      type="string"
     * )
     *
     * @var string
     */
    public $accessToken;

    /**
     * @OA\Property(
     *      title="Refresh Token",
     *      description="A JWT refresh token",
     *      type="string"
     * )
     *
     * @var string
     */
    public $refreshToken;

    /**
     * @OA\Property(
     *     title="Expires At",
     *     description="Expires At",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $expires_in;

    /**
     * @OA\Property(
     *     title="Token Type",
     *     description="Token Type",
     *     example="Bearer",
     *     type="string"
     * )
     *
     * @var string
     */
    public $token_type;

    /**
     * @OA\Property(
     *     title="User Data",
     *     description="User Data",
     * )
     *
     * @var stdClass
     */
    public $userData;

}
