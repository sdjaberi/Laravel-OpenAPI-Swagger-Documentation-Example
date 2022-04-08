<?php

namespace App\Services\Language\Models;

use App\Services\Base\IFilter;
use App\Services\Base\IPageableFilter;


/**
 * @OA\Schema(
 *     title="LanguageFilter",
 *     description="LanguageFilter model",
 *     @OA\Xml(
 *         name="LanguageFilter"
 *     )
 * )
 */
class LanguageFilter extends IFilter
{
    public int $id;

    public string $title;

    public string $local_name;

    public bool $active;

    public string $text_direction;

    public string $iso_code;

    public bool $is_primary;
}
