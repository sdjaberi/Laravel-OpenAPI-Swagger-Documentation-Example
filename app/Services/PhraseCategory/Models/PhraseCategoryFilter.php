<?php

namespace App\Services\PhraseCategory\Models;

use App\Services\Base\IPageableFilter;

/**
 * @OA\Schema(
 *     title="PhraseCategoryFilter",
 *     description="PhraseCategoryFilter model",
 *     @OA\Xml(
 *         name="PhraseCategoryFilter"
 *     )
 * )
 */
class PhraseCategoryFilter extends IPageableFilter
{
    public int $id;

    public int $base_id;

    public int $phrase_category_id;

    public string $phrase;

    public string $category_name;
}
