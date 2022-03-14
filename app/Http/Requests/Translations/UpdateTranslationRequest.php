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

class UpdateTranslationRequest extends FormRequest
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
        $id = $this->input('id');
        $phrase_id = $this->input('phrase_id');
        $language_id = $this->input('language_id');

        $uniquenessRule = Rule::unique('phrase_translations')
            ->where(
                function ($query) use($id, $phrase_id,$language_id) {
                    return
                        $query
                        ->where('phrase_id', $phrase_id)
                        ->where('language_id', $language_id)
                        ->where('id', $id);
        });

        return [
            'phrase_id'   => ['required'],
            'language_id' => ['required'],
            'phrase_language' => [$uniquenessRule],
        ];
    }

    public function messages()
    {
        return [
            'phrase_language.unique' => 'Given phrase_id and language_id are not unique',
        ];
    }
}
