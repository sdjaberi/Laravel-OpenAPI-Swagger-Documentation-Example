<?php

namespace App\Services\Base;

use App\Services\Base\IDto;

class IFilter
{
    /**
     * @OA\Property(
     *     title="SearchQuery",
     *     description="A Search Query",
     *     example="search query"
     * )
     *
     * @var string
     */
    public string $q;
}
