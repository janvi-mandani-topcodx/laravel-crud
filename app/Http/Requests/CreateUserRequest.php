<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'required|string|min:2',
            'lastName' => 'required|string|min:2',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'hobbie' => 'required',
            'gender' => 'required',
            'image' => 'nullable|image',
        ];
    }

    public function messages(): array{
        return [
            'firstName.required' => 'Enter your first name.',
        ];
    }
}
