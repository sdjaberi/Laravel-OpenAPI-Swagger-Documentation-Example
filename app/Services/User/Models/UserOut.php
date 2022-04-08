<?php

namespace App\Services\User\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="UserOut",
 *     description="UserOut model",
 *     @OA\Xml(
 *         name="UserOut"
 *     )
 * )
 */
class UserOut extends IDto
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $id;

    /**
     * @OA\Property(
     *      title="User",
     *      description="User",
     *      example="A new user"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Email",
     *      description="Usert Email",
     *      example="example\@example.example"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Email Verified at",
     *     description="Email Verified at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $email_verified_at ;

}
