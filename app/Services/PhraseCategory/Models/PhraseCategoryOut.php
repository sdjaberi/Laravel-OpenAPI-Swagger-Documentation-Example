<?php

namespace App\Services\PhraseCategory\Models;

use App\Services\Base\IDto;

/**
 * @OA\Schema(
 *     title="PhraseCategoryOut",
 *     description="PhraseCategoryOut model",
 *     @OA\Xml(
 *         name="PhraseCategoryOut"
 *     )
 * )
 */
class PhraseCategoryOut extends IDto
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
     *     title="File Name",
     *     description="File Name",
     *     format="string",
     *     example="[{'@attributes':{'filename':'..\/flux\/views\/settings\/dataschemes\/AccountScheme.qml','line':'26'}}]"
     * )
     *
     * @var integer
     */
    //public $filename ;

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
}
