<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username'  => ['required', 'string', 'email', 'max:255'],
            'password'  => ['required', 'string'],
        ];
    }
}
