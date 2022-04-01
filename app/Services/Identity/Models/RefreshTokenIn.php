<?php

namespace App\Services\Identity\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="RefreshTokenIn",
 *     description="RefreshTokenIn model",
 *     @OA\Xml(
 *         name="RefreshTokenIn"
 *     )
 * )
 */
class RefreshTokenIn extends IDto
{
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

}
