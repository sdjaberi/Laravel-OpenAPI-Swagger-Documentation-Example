<?php

namespace App\Services\Category\Models;

use App\Services\Base\IFilter;


/**
 * @OA\Schema(
 *     title="CategoryFilter",
 *     description="CategoryFilter model",
 *     @OA\Xml(
 *         name="CategoryFilter"
 *     )
 * )
 */
class CategoryFilter extends IFilter
{
    public int $id;

    public int $base_id;

    public int $phrase_category_id;

    public string $phrase;

    public string $category_name;
}
