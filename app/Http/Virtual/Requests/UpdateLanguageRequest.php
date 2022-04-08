<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Update Language request",
 *      description="Update Language request body data",
 *      type="object",
 *      required={"id", "iso_code", "is_primary", "text_direction", "active"}
 * )
 */

class UpdateLanguageRequest
{
        /**
     * @OA\Property(
     *      title="Id",
     *      description="Id",
     *      format="int64",
     *      example=1
     * )
     *
     * @var integer
     */
    private $id;

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
}
