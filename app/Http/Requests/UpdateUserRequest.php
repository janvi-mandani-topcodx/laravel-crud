<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(Request $request): array
    {
        return [
                'firstName'       => 'required|string|min:2',
                'lastName'        => 'required|string|min:2',
                'email'           => 'required|email|unique:users,email,'.$request->user,
                'hobbie'          => 'required',
                'gender'          => 'required',
                'password'        =>['nullable', Password::min(8)->mixedCase()->numbers()],
                'confirmPassword' =>'nullable|min:8|same:password',
                'image'           => ['nullable',File::image()->max('1mb')]
        ];
    }
    public function messages() : array
    {
        return [
            'firstName.required' => 'Enter your first name.',
            'firstName.string' => 'Please enter string.',
            'firstName.min' => 'Please enter at least 2 characeter.',
            'lastName.min' => 'Please enter at least 2 characeter.',
            'lastName.string' => 'Please enter string.',
            'lastName.required' => 'Enter your last name.',
            'email.required' => 'Enter your Email',
            'email.unique' => 'Please enter unique email',
            'password.required' => 'Enter your password',
            'password.mixed_case' => 'Please enter at least 1 uppercase and 1 lowercase',
            'password.min' => 'Please enter at least 8 character',
            'password.numbers' => 'Please enter at least 1 number',
            'confirmPassword.required' => 'Enter your confirm password',
            'confirmPassword.min' => 'Please enter at least 8 character',
            'hobbie.required' => 'Select your hobbie',
            'gender.required' => 'Select your gender',
            'image.image' => 'The uploaded file must be a valid image.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
