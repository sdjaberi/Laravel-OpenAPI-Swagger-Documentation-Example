<?php

namespace App\Http\Requests\Web\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiRequestException;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;
use Illuminate\Support\Facades\Request;

class CategoryImportRequest extends FormRequest
{
    public function authorize()
    {
        $category_name = $this->route()->parameters['name'];

        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(Auth::user()->categories->where('name', $category_name)->isEmpty())
            throw new ApiPermissionException();

        if(!Gate::allows('import'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [];
    }
}
