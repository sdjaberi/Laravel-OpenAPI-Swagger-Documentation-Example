<?php

namespace App\Services\Phrase\Models;

use App\Services\Base\IFilter;
use App\Services\Base\IPageableFilter;


/**
 * @OA\Schema(
 *     title="PhraseFilter",
 *     description="PhraseFilter model",
 *     @OA\Xml(
 *         name="PhraseFilter"
 *     )
 * )
 */
class PhraseFilter extends IFilter
{
    public int $id;

    public int $base_id;

    public int $phrase_category_id;

    public string $phrase;

    public string $category_name;
}
