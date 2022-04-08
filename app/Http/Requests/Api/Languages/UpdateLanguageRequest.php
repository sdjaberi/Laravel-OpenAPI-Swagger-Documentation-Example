<?php

namespace App\Http\Requests\Api\Languages;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => ['required', 'regex:/^([A-Z][a-z0-9]+)+/'],
            'iso_code' => ['min:2', 'max:2', 'required', 'regex:/^[a-z]+$/u'],
            'text_direction' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.regex' => 'The title must be in camelCase Format (example: English / German / French)',
            'iso_code.regex' => 'The iso code must be in lowercase (example: en / de / fr)',
        ];
    }
}
