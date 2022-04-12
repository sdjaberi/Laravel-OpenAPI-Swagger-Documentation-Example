<?php

namespace App\Services\Translation\Models;

use App\Services\Base\IPageableFilter;

/**
 * @OA\Schema(
 *     title="TranslationPageableFilter",
 *     description="TranslationPageableFilter model",
 *     @OA\Xml(
 *         name="TranslationPageableFilter"
 *     )
 * )
 */

class TranslationPageableFilter extends IPageableFilter
{
     /**
     * @OA\Property(
     *     title="Translation",
     *     description="Translation",
     *     example="Homepage"
     * )
     *
     * @var string
     */
    public string $translation;

    /**
     * @OA\Property(
     *     title="Category",
     *     description="Category Name",
     *     example="Website"
     * )
     *
     * @var string
     */
    public string $category;

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
     *     title="Language",
     *     description="Language",
     *     example="English / German"
     * )
     *
     * @var string
     */
    public string $language;


    /**
     * @OA\Property(
     *     title="User",
     *     description="User",
     *     example="John smith"
     * )
     *
     * @var string
     */
    public string $user;


    /**
     * @OA\Property(
     *     title="phraseId",
     *     description="phrase Id",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $phraseId;


    /**
     * @OA\Property(
     *     title="languageId",
     *     description="language Id",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $languageId;


    /**
     * @OA\Property(
     *     title="userId",
     *     description="user Id",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $userId;
}
