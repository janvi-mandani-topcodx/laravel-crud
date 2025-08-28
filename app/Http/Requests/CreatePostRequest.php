<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreatePostRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'imagePost' => ['nullable', File::image()->max('1mb')],
        ];
    }

    public  function messages() : array
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
