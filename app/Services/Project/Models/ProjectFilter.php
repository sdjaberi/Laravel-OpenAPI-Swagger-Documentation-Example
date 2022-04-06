<?php

namespace App\Services\Project\Models;

use App\Services\Base\IPageableFilter;


/**
 * @OA\Schema(
 *     title="ProjectFilter",
 *     description="Project Filter model",
 *     @OA\Xml(
 *         name="ProjectFilter"
 *     )
 * )
 */
class ProjectFilter extends IPageableFilter
{
    public int $id;

    public int $base_id;

    public int $phrase_category_id;

    public string $phrase;

    public string $category_name;
}
