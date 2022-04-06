<?php

namespace App\Http\Virtual\Models;

use App\Http\Virtual\Models\Base\Model;

/**
 * @OA\Schema(
 *     title="Category",
 *     description="Category model",
 *     @OA\Xml(
 *         name="Category"
 *     )
 * )
 */
class Category extends Model
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name",
     *     format="string",
     *     example="Notes"
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
    public $project_id;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description",
     *      example="A new description"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="Icon",
     *      description="Icon",
     *      example="fa fa-explore"
     * )
     *
     * @var string
     */
    public $icon;

}
