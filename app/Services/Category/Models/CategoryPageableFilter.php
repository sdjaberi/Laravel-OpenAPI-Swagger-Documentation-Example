<?php

namespace App\Services\Category\Models;

use App\Services\Base\IPageableFilter;
use App\Services\Category\Models\CategoryFilter;

/**
 * @OA\Schema(
 *     title="CategoryPageableFilter",
 *     description="CategoryPageableFilter model",
 *     @OA\Xml(
 *         name="CategoryPageableFilter"
 *     )
 * )
 */
class CategoryPageableFilter extends IPageableFilter
{
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
    public string $project;
}
