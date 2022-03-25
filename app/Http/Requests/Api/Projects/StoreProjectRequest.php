<?php

namespace App\Http\Requests\Api\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Exceptions\ApiRequestException;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiUnAuthException;
use App\Http\Exceptions\ApiPermissionException;
use App\Http\Middleware;

class StoreProjectRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required']
        ];
    }
}
