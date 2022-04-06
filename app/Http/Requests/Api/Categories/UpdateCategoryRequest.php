<?php

namespace App\Http\Requests\Api\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'unique:categories,name,'.$this->category->name.',name'],
        ];
    }
}
