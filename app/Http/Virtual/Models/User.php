<?php

namespace App\Http\Virtual\Models;

use App\Http\Virtual\Models\Base\Model;

/**
 * @OA\Schema(
 *     title="User",
 *     description="User model",
 * )
 */
class User extends Model
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name",
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Email",
     *     description="Email",
     *     format="email",
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *     title="Email verified at",
     *     description="Email verified at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    public $email_verified_at;
}
