<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Update Phrase request",
 *      description="Update Phrase request body data",
 *      type="object",
 *      required={"phrase","category_name"}
 * )
 */

class UpdatePhraseRequest
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
}
