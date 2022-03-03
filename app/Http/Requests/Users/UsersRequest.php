<?php

namespace App\Http\Requests\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UsersRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'offset' => ['required', 'integer'],
            'limit'  => ['required', 'string'],
        ];
    }
}
