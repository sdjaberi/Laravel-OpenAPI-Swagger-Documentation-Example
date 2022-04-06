<?php

namespace App\Http\Virtual\Models;

use App\Http\Virtual\Models\Base\Model;

/**
 * @OA\Schema(
 *     title="Phrase",
 *     description="Phrase model",
 *     @OA\Xml(
 *         name="Phrase"
 *     )
 * )
 */
class Phrase extends Model
{
    /**
     * @OA\Property(
     *     title="Base ID",
     *     description="Base ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $base_id;

    /**
     * @OA\Property(
     *      title="Phrase",
     *      description="Phrase",
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
     *     title="Phrase Category ID",
     *     description="Phrase Category ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $phrase_category_id;
}
