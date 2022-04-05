<?php

namespace App\Services\Base;

use App\Services\Base\IFilter;

class IPageableFilter extends IFilter
{
    public int $page;

    public int $perPage;

    public string $sortBy;

    public bool $sortDesc;
}
