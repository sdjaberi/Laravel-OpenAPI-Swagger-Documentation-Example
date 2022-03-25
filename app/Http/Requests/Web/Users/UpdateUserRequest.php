<?php

namespace App\Http\Requests\Web\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('user_edit'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [
            'name'          => ['required'],
            'email'         => ['required', 'email','unique:users,email,'.$this->user->id],
            'roles.*'       => ['integer'],
            'roles'         => ['required','array'],
            'categories.*'  => ['string'],
            'categories'    => ['required','array'],
            'languages.*'   => ['integer'],
            'languages'     => ['required','array'],
        ];
    }
}
