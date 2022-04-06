<?php

namespace App\Http\Requests\Api\Categories;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:categories',]
        ];
    }
}
