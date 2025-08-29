<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'required|string',
            'image' => ['nullable', File::image()->max('1mb')],
        ];
    }

    public  function messages() : array
    {
        return [
            'title.required' => 'Enter your title.',
            'description.required' => 'Enter your description.',
            'status.required' => 'Enter your status',
            'image.image' => 'The uploaded file must be a valid image.',
            'image.max' => 'The image size must not exceed 2MB.',
        ];
    }
}
