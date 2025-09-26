<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'title' => 'required' ,
            'description' => 'required',
            'variantTitle.*' => 'required',
            'price.*' => 'required',
            'sku.*' => 'required',
        ];
    }

    public  function messages() : array
    {
        return [
            'title.required' =>  'Enter title',
            'description.required' =>  'Enter description',
            'variantTitle.*.required' =>  'Enter variant title',
            'price.*.required' =>  'Enter price',
            'sku.*.required' =>  'Enter sku',
        ];
    }

}
