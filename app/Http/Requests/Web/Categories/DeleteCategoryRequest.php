<?php

namespace App\Http\Requests\Web\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;

class DeleteCategoryRequest extends FormRequest
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
        return [];
    }
}
