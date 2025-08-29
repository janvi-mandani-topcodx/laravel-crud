<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required',
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required|same:newPassword'
        ];
    }

    public function messages() : array
    {
        return [
            'email.required'  => 'Enter your email',
            'oldPassword.required' => 'Enter your old password',
            'newPassword.required' => 'Enter your new password',
            'confirmPassword.required' => 'Enter your confirm password'
        ];
    }
}
