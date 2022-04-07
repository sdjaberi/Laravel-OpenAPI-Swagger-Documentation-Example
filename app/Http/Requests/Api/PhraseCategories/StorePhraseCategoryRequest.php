<?php

namespace App\Http\Requests\Api\PhraseCategories;

use Illuminate\Foundation\Http\FormRequest;

class StorePhraseCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:phrase_categories',]
        ];
    }
}
