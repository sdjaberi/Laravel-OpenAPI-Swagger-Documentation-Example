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
     *     title="Skip",
     *     description="Skip",
     *     example="100"
     * )
     *
     * @var integer
     */
    public int $skip;

    /**
     * @OA\Property(
     *     title="Limit",
     *     description="Limit",
     *     example="200"
     * )
     *
     * @var integer
     */
    public int $limit;

    /**
     * @OA\Property(
     *     title="Sort",
     *     description="Sort",
     *     example="asc or decs"
     * )
     *
     * @var string
     */
    public string $sort;

}
