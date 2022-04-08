<?php

namespace App\Services\Language\Models;

use App\Services\Base\IPageableFilter;

/**
 * @OA\Schema(
 *     title="LanguagePageableFilter",
 *     description="LanguagePageableFilter model",
 *     @OA\Xml(
 *         name="LanguagePageableFilter"
 *     )
 * )
 */

class LanguagePageableFilter extends IPageableFilter
{
    /**
     * @OA\Property(
     *     title="Language",
     *     description="Language",
     *     example="Homepage"
     * )
     *
     * @var string
     */
    public string $language;

    /**
     * @OA\Property(
     *     title="User",
     *     description="User",
     *     example="John Smith"
     * )
     *
     * @var string
     */
    public string $user;


    /**
     * @OA\Property(
     *     title="UserId",
     *     description="User Id",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $userId;


    /**
     * @OA\Property(
     *     title="Project",
     *     description="Project",
     *     example="PrimeLabe 2.0"
     * )
     *
     * @var string
     */
    public string $project;


    /**
     * @OA\Property(
     *     title="ProjectId",
     *     description="Project Id",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $projectId;


    /**
     * @OA\Property(
     *     title="Translation",
     *     description="Translation",
     *     example="John Smith"
     * )
     *
     * @var string
     */
    public string $translation;

    /**
     * @OA\Property(
     *     title="TranslationId",
     *     description="Translation Id",
     *     example=1
     * )
     *
     * @var integer
     */
    public int $translationId;
}
