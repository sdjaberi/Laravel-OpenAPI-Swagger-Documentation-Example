<?php

namespace App\Http\Requests\Web\Phrases;

use App\Models\Phrase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;

class UpdatePhraseRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('phrase_edit'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [
            'phrase' => ['required'],
            'category_name' => ['required']
        ];
    }
}
