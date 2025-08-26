<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        return [
                 'firstName' => 'required|string|min:2',
                 'lastName' => 'required|string|min:2',
                 'email' => 'required|email|unique:users,email,'.$request->user,
                 'password' => 'required|min:8',
                 'hobbie' => 'required',
                 'gender' => 'required',
                 'image' => 'nullable|image',
        ];
    }
    public function messages() : array
    {
        return [
            'email.unique' => 'please enter unique email',
        ];
    }
}
