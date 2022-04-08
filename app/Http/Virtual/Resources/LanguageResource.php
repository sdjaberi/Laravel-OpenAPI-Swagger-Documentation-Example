<?php

namespace App\Http\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="LanguageResource",
 *     description="Language resource",
 *     @OA\Xml(
 *         name="LanguageResource"
 *     )
 * )
 */
class LanguageResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Language[]
     */
    private $data;
}
