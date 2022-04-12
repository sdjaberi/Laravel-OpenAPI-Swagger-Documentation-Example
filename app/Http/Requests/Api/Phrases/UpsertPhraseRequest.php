<?php

namespace App\Http\Requests\Api\Phrases;

use Illuminate\Foundation\Http\FormRequest;

class UpsertPhraseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phrase' => ['required'],
            'category_name' => ['required']
        ];
    }
}
