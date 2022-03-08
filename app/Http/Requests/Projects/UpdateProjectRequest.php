<?php

namespace App\Http\Requests\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        if(!Gate::allows('project_edit'))
            throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }
}
