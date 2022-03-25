<?php

namespace App\Http\Requests\Web\Languages;

use App\Models\Language;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;

class UpdateLanguageRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('language_edit'))
            throw new ApiPermissionException();

        return true;
    }
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
