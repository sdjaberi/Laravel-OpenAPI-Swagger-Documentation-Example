<?php

namespace App\Services\User\Models;

use App\Services\Base\IPageableFilter;

/**
 * @OA\Schema(
 *     title="UserPageableFilter",
 *     description="UserPageableFilter model",
 *     @OA\Xml(
 *         name="UserPageableFilter"
 *     )
 * )
 */

class UserPageableFilter extends IPageableFilter
{
    /**
     * @OA\Property(
     *     title="User",
     *     description="User",
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
     *     title="phraseCategoryId",
     *     description="phrase Category Id",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $phraseCategoryId;


    /**
     * @OA\Property(
     *     title="UserCategory",
     *     description="UserCategory",
     *     example="Setting"
     * )
     *
     * @var string
     */
    public string $phraseCategory;

}
