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
     *     title="User ID",
     *     description="User id",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $user_id;

    /**
     * @OA\Property(
     *      title="Token ID",
     *      description="A JWT token id",
     *      type="int64"
     * )
     *
     * @var string
     */
    public $token_id;

    /**
     * @OA\Property(
     *      title="Token",
     *      description="A JWT token",
     *      type="string"
     * )
     *
     * @var string
     */
    public $token;

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
    public $expires_at;

    /**
     * @OA\Property(
     *      title="Refresh Token",
     *      description="A JWT token",
     *      type="string"
     * )
     *
     * @var string
     */
    public $refreshToken;

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


    //----------------------------

    /**
     * @OA\Property(
     *     title="User",
     *     description="User model"
     * )
     *
     * @var \App\Virtual\Models\User
     */
    public $user;


    /**
     * @OA\Property(
     *     title="Role",
     *     description="Role model"
     * )
     *
     * @var \App\Virtual\Models\Role
     */
    public $role;
}
