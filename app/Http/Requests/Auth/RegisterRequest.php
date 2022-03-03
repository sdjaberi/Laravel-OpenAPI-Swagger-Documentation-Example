<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required|string',
            ],
            'email' => [
                'required|string|email|unique:users',
            ],
            'password' => [
                'required|string',
            ],
        ];
    }
}
