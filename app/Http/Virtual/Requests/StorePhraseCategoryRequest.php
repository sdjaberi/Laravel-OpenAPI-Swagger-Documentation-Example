<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Store Phrase Category request",
 *      description="Store Phrase Category request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class StorePhraseCategoryRequest
{
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name",
     *      example="A new phrase category name"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description",
     *      example="A phrase category description"
     * )
     *
     * @var string
     */
    public $filename;
}
