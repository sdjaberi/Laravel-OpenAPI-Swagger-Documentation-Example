<?php

namespace App\Services\Project\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="ProjectOut",
 *     description="ProjectOut model",
 *     @OA\Xml(
 *         name="ProjectOut"
 *     )
 * )
 */
class ProjectOut extends IDto
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
     * @var \App\Services\Project\Models\ProjectOut
     */
    public $project;

}
