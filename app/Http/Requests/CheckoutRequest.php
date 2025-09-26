<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'first_name' => 'required' ,
            'last_name' => 'required',
            'address' => 'required',
            'state' => 'required',
            'country' => 'required',
            'delivery' => 'required',
        ];
    }

    public  function messages() : array
    {
        return [
            'first_name.required' =>  'Enter first name.',
            'lastName.required' =>  'Enter last name.',
            'address.required' =>  'Enter address.',
            'state.required' =>  'Enter state.',
            'country.required' =>  'Enter country.',
            'delivery.required' =>  'Enter delivery.',
        ];
    }
}
