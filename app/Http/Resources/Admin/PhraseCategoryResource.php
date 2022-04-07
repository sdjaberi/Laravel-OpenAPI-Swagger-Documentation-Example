<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class PhraseCategoryResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'phraseCategory';

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
