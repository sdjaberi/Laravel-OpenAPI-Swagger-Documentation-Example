<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiRequestException;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('user_create'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [
            'name'          => ['required'],
            'email'         => ['required', 'email','unique:users'],
            'password'      => ['required'],
            'roles.*'       => ['integer'],
            'roles'         => ['required','array'],
            'categories.*'  => ['string'],
            'categories'    => ['required','array'],
            'languages.*'   => ['integer'],
            'languages'     => ['required','array'],
        ];
    }
}
