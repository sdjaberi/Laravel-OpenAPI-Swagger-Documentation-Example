<?php

namespace App\Http\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="PhraseCategoryResource",
 *     description="Phrase Category resource",
 *     @OA\Xml(
 *         name="PhraseCategoryResource"
 *     )
 * )
 */
class PhraseCategoryResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\PhraseCategory[]
     */
    private $data;
}
