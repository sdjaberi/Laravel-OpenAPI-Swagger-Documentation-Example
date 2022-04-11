<?php

namespace App\Http\Requests\Api\Translations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTranslationRequest extends FormRequest
{
    public function rules()
    {
        $id = (int)$this->route()->translation->id;
        $phrase_id = (int)$this->input('phrase_id');
        $language_id = (int)$this->input('language_id');

        $uniquenessRule = Rule::unique('phrase_translations')
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
