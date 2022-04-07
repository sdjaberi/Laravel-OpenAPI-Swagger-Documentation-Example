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
     *     title="File Name",
     *     description="File Name",
     *     format="string",
     *     example="[{'@attributes':{'filename':'..\/flux\/views\/settings\/dataschemes\/AccountScheme.qml','line':'26'}}]"
     * )
     *
     * @var integer
     */
    public $filename ;

    /**
     * @OA\Property(
     *     title="Phrase Count",
     *     description="Phrases Count",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    public $phrases_count;
}
