<?php

namespace App\Http\Requests\Translations;

use App\Models\Translation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;
use Illuminate\Validation\Rule;

class UpdateTranslationAjaxRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('translation_edit'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        $id = (int)$this->input('id');
        $phrase_id = (int)$this->input('phrase_id');
        $language_id = (int)$this->input('language_id');

        $uniquenessRule =
        Rule::unique('phrase_translations')
            ->where(
                fn ($query) =>
                        $query
                            ->where([
                                'language_id' => $language_id,
                                'phrase_id' => $phrase_id,
                                ])
                    )
            ->ignore($id);

        return [
            'translation' => ['required'],
            'phrase_id'   => ['required', $uniquenessRule],
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
