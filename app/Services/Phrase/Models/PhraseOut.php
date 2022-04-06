<?php

namespace App\Services\Phrase\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="PhraseOut",
 *     description="PhraseOut model",
 *     @OA\Xml(
 *         name="PhraseOut"
 *     )
 * )
 */
class PhraseOut extends IDto
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

    /**
     * @OA\Property(
     *     title="Translations Count",
     *     description="Translations Count",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $translations_count;

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
    public $created_at;

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
    public $updated_at;

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
    public $deleted_at;


    /************************* Models **********************/
    /**
     * @OA\Property(
     *      title="PhraseCategory",
     *      description="Phrase Category Model",
     * )
     *
     * @var \App\Services\PhraseCategory\Models\PhraseCategoryOut
     */
    public $phraseCategory;

    /**
     * @OA\Property(
     *      title="Category",
     *      description="Category Model",
     * )
     *
     * @var \App\Services\Category\Models\CategoryOut
     */
    public $category;
}
