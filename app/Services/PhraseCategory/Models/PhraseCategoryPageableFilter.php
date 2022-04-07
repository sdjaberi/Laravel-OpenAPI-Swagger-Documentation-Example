<?php

namespace App\Services\PhraseCategory\Models;

use App\Services\Base\IPageableFilter;
use App\Services\PhraseCategory\Models\PhraseCategoryFilter;

/**
 * @OA\Schema(
 *     title="PhraseCategoryPageableFilter",
 *     description="PhraseCategoryPageableFilter model",
 *     @OA\Xml(
 *         name="PhraseCategoryPageableFilter"
 *     )
 * )
 */
class PhraseCategoryPageableFilter extends IPageableFilter
{
    /**
     * @OA\Property(
     *     title="Phrase Category Name",
     *     description="Phrase Category Name",
     *     example="A phrase category name"
     * )
     *
     * @var string
     */
    public string $phraseCategory;
}
