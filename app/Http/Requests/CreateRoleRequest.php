<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'role' => 'required'
        ];
    }

    public  function messages() : array
    {
       return [
           'role.required' =>  'Enter role'
       ];
    }
}
