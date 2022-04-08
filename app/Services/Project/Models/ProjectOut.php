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
     *     title="Author ID",
     *     description="Author ID",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $author_id;


    /************************* Models **********************/
    /**
     * @OA\Property(
     *      title="Author",
     *      description="Author Model",
     * )
     *
     * @var \App\Services\User\Models\UserOut
     */
    public $author;

    /**
     * @OA\Property(
     *      title="Languages",
     *      description="Languages",
     * )
     *
     * @var \App\Services\Language\Models\LanguageOut[]
     */
    public $languages;

    /**
     * @OA\Property(
     *      title="Categories",
     *      description="Categories",
     * )
     *
     * @var \App\Services\Category\Models\CategoryOut[]
     */
    public $categories;
}
