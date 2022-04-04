<?php

namespace App\Http\Requests\Api\Projects;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required']
        ];
    }
}
