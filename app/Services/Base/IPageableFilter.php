<?php

namespace App\Services\Base;

use App\Services\Base\IFilter;

class IPageableFilter extends IFilter
{
    public int $skip;

    public int $limit;

    public string $sort;
}
