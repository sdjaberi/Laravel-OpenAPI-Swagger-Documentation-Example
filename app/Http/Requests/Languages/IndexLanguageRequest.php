<?php

namespace App\Http\Requests\Languages;

use App\Models\Language;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;

class IndexLanguageRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('language_access'))
            throw new ApiPermissionException();

        return true;
    }

    public function bearerToken()
    {
        if(Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(Gate::allows('language_access'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [];
    }
}
