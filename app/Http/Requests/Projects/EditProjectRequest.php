<?php

namespace App\Http\Requests\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiRequestException;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;

class EditProjectRequest extends FormRequest
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
        return [];
    }
}
