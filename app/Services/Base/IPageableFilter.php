<?php

namespace App\Services\Base;

use App\Services\Base\IFilter;

class IPageableFilter extends IFilter
{
    /**
     * @OA\Property(
     *     title="Page",
     *     description="Page",
     *     example="2"
     * )
     *
     * @var integer
     */
    public int $page;

    /**
     * @OA\Property(
     *     title="PerPage",
     *     description="PerPage",
     *     example="100"
     * )
     *
     * @var integer
     */
    public int $perPage;

    /**
     * @OA\Property(
     *     title="SortBY",
     *     description="SortBy",
     *     example="id"
     * )
     *
     * @var string
     */
    public string $sortBy;


    /**
     * @OA\Property(
     *     title="SortDesc",
     *     description="SortDesc",
     *     example="true"
     * )
     *
     * @var bool
     */
    public bool $sortDesc;
}
