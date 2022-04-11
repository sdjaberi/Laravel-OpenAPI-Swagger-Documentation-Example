<?php

namespace App\Services\User\Models;

use App\Services\Base\IFilter;
use App\Services\Base\IPageableFilter;


/**
 * @OA\Schema(
 *     title="UserFilter",
 *     description="UserFilter model",
 *     @OA\Xml(
 *         name="UserFilter"
 *     )
 * )
 */
class UserFilter extends IFilter
{
    public int $id;

    public int $base_id;

    public int $phrase_category_id;

    public string $phrase;

    public string $category_name;
}
