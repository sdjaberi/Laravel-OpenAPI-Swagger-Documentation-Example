<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Upsert Phrase request",
 *      description="Upsert Phrase request body data",
 *      type="object",
 *      required={"base_id", "phrase", "category_name"}
 * )
 */

class UpsertPhraseRequest
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
     *     title="Phrase Category Name",
     *     description="Phrase Category Name",
     *     format="string",
     *     example="Settings"
     * )
     *
     * @var integer
     */
    private $phrase_category_name;
}
