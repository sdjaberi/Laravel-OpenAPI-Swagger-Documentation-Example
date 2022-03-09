<?php

namespace App\Http\Requests\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategoryRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('category_delete'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [
            'names'   => ['required', 'array'],
            'names.*' => ['exists:categories,name'],
        ];
    }
}
