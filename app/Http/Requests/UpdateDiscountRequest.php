<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscountRequest extends FormRequest
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
            'code' => 'required',
            'value' => 'required | integer',
            'minimum_purchase'=>'required_if:requirement,purchase_amount',
            'minimum_quantity'=>'required_if:requirement,quantity_amount',
            'customer_name' => 'required_if:customer,specific_customer',
            'limit_number_discount' => 'required_if:how_many_times,how_many_times_use_discount',
            'product_name' => 'required_if:product,specific_product',
            'start_date' => 'required',
            'end_date' => 'required_if:end_date_checkbox,end_date',
        ];
    }
}
