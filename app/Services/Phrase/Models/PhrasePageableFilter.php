<?php

namespace App\Services\Phrase\Models;

use App\Services\Base\IPageableFilter;
use App\Services\Phrase\Models\PhraseFilter;

/**
 * @OA\Schema(
 *     title="PhrasePageableFilter",
 *     description="PhrasePageableFilter model",
 *     @OA\Xml(
 *         name="PhrasePageableFilter"
 *     )
 * )
 */

class PhrasePageableFilter extends IPageableFilter
{
    /**
     * @OA\Property(
     *     title="Phrase",
     *     description="Phrase",
     *     example="Homepage"
     * )
     *
     * @var string
     */
    public string $phrase;

    /**
     * @OA\Property(
     *     title="Category",
     *     description="Category",
     *     example="Website"
     * )
     *
     * @var string
     */
    public string $category;


    /**
     * @OA\Property(
     *     title="PhraseCategory",
     *     description="PhraseCategory",
     *     example="Setting"
     * )
     *
     * @var string
     */
    public string $phraseCategory;

}
