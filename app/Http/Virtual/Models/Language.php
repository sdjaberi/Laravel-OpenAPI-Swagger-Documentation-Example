<?php

namespace App\Http\Virtual\Models;

use App\Http\Virtual\Models\Base\Model;

/**
 * @OA\Schema(
 *     title="Language",
 *     description="Language model",
 *     @OA\Xml(
 *         name="Language"
 *     )
 * )
 */
class Language extends Model
{
    /**
     * @OA\Property(
     *      title="Language",
     *      description="Language",
     *      example="A new phrase"
     * )
     *
     * @var string
     */
    public $phrase;

    /**
     * @OA\Property(
     *      title="Category Name",
     *      description="Category Name",
     *      example="A category name"
     * )
     *
     * @var string
     */
    public $category_name;

    /**
     * @OA\Property(
     *     title="Language Category ID",
     *     description="Language Category ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $phrase_category_id;
}
