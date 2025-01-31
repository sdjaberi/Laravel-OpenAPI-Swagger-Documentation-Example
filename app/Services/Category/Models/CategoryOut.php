<?php

namespace App\Services\Category\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="CategoryOut",
 *     description="CategoryOut model",
 *     @OA\Xml(
 *         name="CategoryOut"
 *     )
 * )
 */
class CategoryOut extends IDto
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

    /************************* Models **********************/
    /**
     * @OA\Property(
     *      title="PhraseCategory",
     *      description="Phrase Category Model",
     * )
     *
     * @var \App\Services\Project\Models\ProjectOut
     */
    public $project;
}
