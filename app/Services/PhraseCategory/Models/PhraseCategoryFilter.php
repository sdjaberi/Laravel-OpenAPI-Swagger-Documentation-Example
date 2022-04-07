<?php

namespace App\Services\PhraseCategory\Models;

use App\Services\Base\IFilter;

/**
 * @OA\Schema(
 *     title="PhraseCategoryFilter",
 *     description="PhraseCategoryFilter model",
 *     @OA\Xml(
 *         name="PhraseCategoryFilter"
 *     )
 * )
 */
class PhraseCategoryFilter extends IFilter
{
    public int $id;

    public int $name;

    public int $filename;
}
