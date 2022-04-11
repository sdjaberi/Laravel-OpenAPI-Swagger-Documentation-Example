<?php

namespace App\Http\Requests\Api\Translations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTranslationRequest extends FormRequest
{
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
