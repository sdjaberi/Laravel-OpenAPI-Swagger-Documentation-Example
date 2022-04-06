<?php

namespace App\Http\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Update category request",
 *      description="Update category request body data",
 *      type="object",
 *      required={"name"}
 * )
 */

class UpdateCategoryRequest
{
    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name",
     *      example="A new category name"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *     title="Project ID",
     *     description="Project ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $project_id;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description",
     *      example="A category description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *     title="Icon",
     *     description="Icon",
     *     example="fa fa-user"
     * )
     *
     * @var string
     */
    private $icon;
}
