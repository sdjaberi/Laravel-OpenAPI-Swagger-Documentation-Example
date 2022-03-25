<?php

namespace App\Http\Requests\Web\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;
use Laravel\Passport\Passport;

class IndexProjectRequest extends FormRequest
{
    public function authorize()
    {
        //if($request->user()->tokenCan('place-orders'))
            //throw new ApiUnAuthException('Please Login First');



        //if(!Gate::allows('project_access'))
            //throw new ApiPermissionException();

        return true;
    }

    public function rules()
    {
        return [];
    }
}
