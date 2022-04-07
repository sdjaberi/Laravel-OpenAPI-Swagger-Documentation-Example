<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Update phrase category request",
 *      description="Update phrase category request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class UpdatePhraseCategoryRequest
{
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name",
     *      example="A new phrase phrase category name"
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
