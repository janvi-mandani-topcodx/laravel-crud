<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title.required' => 'Enter your title.',
            'description.required' => 'Enter your description.',
            'status.required' => 'Enter your status',
            'imagePost.image' => 'The uploaded file must be a valid image.',
            'imagePost.max' => 'The image size must not exceed 2MB.',
        ];
    }

    public function messages() : array
    {
        return [
            'title.required' => 'Enter your title.',
            'description.required' => 'Enter your description.',
            'status.required' => 'Enter your status',
            'imagePost.image' => 'The uploaded file must be a valid image.',
            'imagePost.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
