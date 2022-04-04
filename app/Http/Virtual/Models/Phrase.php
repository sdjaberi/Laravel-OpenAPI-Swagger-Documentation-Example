<?php

namespace App\Http\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Phrase",
 *     description="Phrase model",
 *     @OA\Xml(
 *         name="Phrase"
 *     )
 * )
 */
class Phrase
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

    private $id;

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
    private $base_id;

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
    private $phrase_category_id;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *     title="Deleted at",
     *     description="Deleted at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $deleted_at;
}
