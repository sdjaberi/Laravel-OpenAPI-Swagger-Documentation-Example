<?php

namespace App\Services\Phrase\Models;

use App\Services\Base\IPageableFilter;
use App\Services\Phrase\Models\PhraseFilter;

/**
 * @OA\Schema(
 *     title="PhrasePageableFilter",
 *     description="PhrasePageableFilter model",
 *     @OA\Xml(
 *         name="PhrasePageableFilter"
 *     )
 * )
 */
class PhrasePageableFilter extends PhraseFilter
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


    /**
     * @OA\Property(
     *     title="Phrase",
     *     description="Phrase",
     *     example="Homepage"
     * )
     *
     * @var string
     */
    public string $phrase;

    /**
     * @OA\Property(
     *     title="Category",
     *     description="Category",
     *     example="Website"
     * )
     *
     * @var string
     */
    public string $category;


    /**
     * @OA\Property(
     *     title="PhraseCategory",
     *     description="PhraseCategory",
     *     example="Setting"
     * )
     *
     * @var string
     */
    public string $phraseCategory;

}
