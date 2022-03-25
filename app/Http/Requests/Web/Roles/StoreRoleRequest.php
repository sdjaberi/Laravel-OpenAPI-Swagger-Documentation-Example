<?php

namespace App\Http\Requests\Web\Roles;

use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;

class StoreRoleRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('role_create'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [
            'title'         => ['required'],
            'permissions.*' => ['integer'],
            'permissions'   => ['required', 'array'],
        ];
    }
}
