<?php

namespace App\Http\Virtual\Models;

use App\Http\Virtual\Models\Base\Model;

/**
 * @OA\Schema(
 *     title=" Phrase Category ",
 *     description=" Phrase Category  model",
 *     @OA\Xml(
 *         name=" Phrase Category "
 *     )
 * )
 */
class  PhraseCategory  extends Model
{
    /**
     * @OA\Property(
     *     title="Name",
     *     description="Name",
     *     format="string",
     *     example="Setting"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Filename",
     *      description="Filename",
     *      example="A new Filename"
     * )
     *
     * @var string
     */
    public $filename;
}
