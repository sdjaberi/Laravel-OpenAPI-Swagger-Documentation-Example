<?php

namespace App\Http\Requests\Web\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Exceptions\ApiUnAuthException;

class DeleteProjectRequest extends FormRequest
{
    public function authorize()
    {
        //dd($this->input('id'));

        if(!Auth::user())
            throw new ApiUnAuthException('Please Login First');

        //if(!Gate::allows('project_delete'))
            //throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [];
    }
}
