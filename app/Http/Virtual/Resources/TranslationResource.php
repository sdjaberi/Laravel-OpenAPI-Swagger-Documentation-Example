<?php

namespace App\Http\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="TranslationResource",
 *     description="Translation resource",
 *     @OA\Xml(
 *         name="TranslationResource"
 *     )
 * )
 */
class TranslationResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Translation[]
     */
    private $data;
}
