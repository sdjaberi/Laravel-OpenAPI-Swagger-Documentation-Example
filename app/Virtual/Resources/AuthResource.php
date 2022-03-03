<?php

namespace App\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="AuthResource",
 *     description="Auth resource",
 *     @OA\Xml(
 *         name="AuthResource"
 *     )
 * )
 */
class AuthResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Auth[]
     */
    private $data;
}
