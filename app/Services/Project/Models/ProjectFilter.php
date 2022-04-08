<?php

namespace App\Services\Project\Models;

use App\Services\Base\IFilter;
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
class ProjectFilter extends IFilter
{
    public int $id;

    public int $name;

    public int $author_id;

    public string $description;
}
