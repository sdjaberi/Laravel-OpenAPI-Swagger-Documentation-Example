<?php

namespace App\Http\Requests\Web\Translations;

use App\Models\Translation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTranslationRequest extends FormRequest
{
    public function authorize()
    {
        //dd("salam");

        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('translation_delete'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => ['required', 'array'],
            //'ids.*' => ['exists:phrase_translations,id'],
        ];
    }
}
