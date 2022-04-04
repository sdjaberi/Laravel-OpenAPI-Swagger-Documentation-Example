<?php

namespace App\Http\Virtual\Resources;

/**
 * @OA\Schema(
 *     title="PhraseResource",
 *     description="Phrase resource",
 *     @OA\Xml(
 *         name="PhraseResource"
 *     )
 * )
 */
class PhraseResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Virtual\Models\Phrase[]
     */
    private $data;
}
