<?php

namespace App\Http\Requests\Web\Translations;

use App\Models\Translation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiRequestException;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;
use Illuminate\Validation\Rule;

class StoreTranslationRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('translation_create'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        $phrase_id = $this->input('phrase_id');
        $language_id = $this->input('language_id');

        $uniquenessRule = Rule::unique('phrase_translations')
            ->where(
                function ($query) use($phrase_id,$language_id) {
                    return
                        $query
                            ->where('phrase_id', $phrase_id)
                            ->where('language_id', $language_id);
        });

        return [
            'phrase_id' => ['required', $uniquenessRule],
            'language_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'phrase_id.unique' => 'Given phrase_id and language_id are not unique',
        ];
    }
}
