<?php

namespace App\Services\Project\Models;

use App\Services\Base\IPageableFilter;

/**
 * @OA\Schema(
 *     title="ProjectPageableFilter",
 *     description="Project Pageable Filter model",
 *     @OA\Xml(
 *         name="ProjectPageableFilter"
 *     )
 * )
 */
class ProjectPageableFilter extends IPageableFilter
{
    /**
     * @OA\Property(
     *     title="Project",
     *     description="Project Name",
     *     example="Poollab 1.0"
     * )
     *
     * @var string
     */
    public string $project;
}
