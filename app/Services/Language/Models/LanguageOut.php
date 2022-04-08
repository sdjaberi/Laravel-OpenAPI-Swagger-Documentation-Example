<?php

namespace App\Services\Language\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="LanguageOut",
 *     description="LanguageOut model",
 *     @OA\Xml(
 *         name="LanguageOut"
 *     )
 * )
 */
class LanguageOut extends IDto
{
    /**
     * @OA\Property(
     *     title="ID",
     *     description="ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $id;

    /**
     * @OA\Property(
     *      title="Title",
     *      description="Title",
     *      example="A new language title"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="IsoCode",
     *      description="ISO Code",
     *      example="A language iso code like en / de /.."
     * )
     *
     * @var string
     */
    public $iso_code;


    /**
     * @OA\Property(
     *      title="IsPrimary",
     *      description="Is Primary",
     *      example="1"
     * )
     *
     * @var bool
     */
    public $is_primary;

    /**
     * @OA\Property(
     *      title="TextDirection",
     *      description="Text Direction",
     *      example="ltr or rtl"
     * )
     *
     * @var string
     */
    public $text_direction;

        /**
     * @OA\Property(
     *      title="LocalName",
     *      description="Local Name",
     *      example="english / deutsche / .."
     * )
     *
     * @var string
     */
    public $local_name;

    /**
     * @OA\Property(
     *      title="Active",
     *      description="Active",
     *      example="1"
     * )
     *
     * @var bool
     */
    public $active;

    /**
     * @OA\Property(
     *     title="UsersCount",
     *     description="Users Count",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $users_count;

    /**
     * @OA\Property(
     *     title="ProjectsCount",
     *     description="Projects Count",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $projects_count;

    /**
     * @OA\Property(
     *     title="TranslationsCount",
     *     description="Translations Count",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $translations_count;
}
