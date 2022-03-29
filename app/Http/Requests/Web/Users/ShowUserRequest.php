<?php

namespace App\Http\Requests\Web\Users;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;

class ShowUserRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('user_show'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [];
    }
}
