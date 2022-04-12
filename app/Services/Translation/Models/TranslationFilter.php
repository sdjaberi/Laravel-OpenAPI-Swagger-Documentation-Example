<?php

namespace App\Services\Translation\Models;

use App\Services\Base\IFilter;
use App\Services\Base\IPageableFilter;


/**
 * @OA\Schema(
 *     title="TranslationFilter",
 *     description="TranslationFilter model",
 *     @OA\Xml(
 *         name="TranslationFilter"
 *     )
 * )
 */
class TranslationFilter extends IFilter
{
    public int $id;

    public string $translation;

    public string $category;

    public int $phrase_id;

    public int $language_id;

    public int $user_id;

}
