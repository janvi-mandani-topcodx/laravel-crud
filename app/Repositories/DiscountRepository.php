<?php

namespace App\Repositories;
use App\Models\Discount;
use App\Models\UsersDemo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class DiscountRepository extends BaseRepository
{
    public function model()
    {
        return Discount::class;
    }
    public function store($data)
    {
        Discount::create([
            'code' => $data['code'],
            'amount' => $data['value'],
            'type' => $data['type'],
            'minimum_requirements' => $data['requirement'],
            'minimum_amount' => $data['minimum_purchase'] ?? $data['minimum_quantity'],
            'customer_eligibility' => $data['customer'],
            'customer_id' => $data['customer_id'],
            'applies_product' => $data['product'],
            'product_id' => $data['product_id'],
            'usage_limit_number_of_times_use' => isset($data['limit_number_discount']) ? 1 : 0,
            'usage_limit_number' => $data['limit_number_discount'],
            'usage_limit_one_user_per_customer' => isset($data['limit_one_use']) ? 1 : 0,
            'usage_limit_new_customer' => isset($data['limit_new_customer']) ? 1 : 0,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => isset($data['status']) && $data['status']== 'on' ? 1 : 0
        ]);
    }


    public function update($data , $discountData)
    {
//        dump($discountData , $data );
        $productId = $data['product'] == 'all_products' ? null : $data['product_id'];
//        dd($productId);
        $discountData->update([
            'code' => $data['code'],
            'amount' => $data['value'],
            'type' => $data['type'],
            'minimum_requirements' => $data['requirement'],
            'minimum_amount' => $data['minimum_purchase'] ?? $data['minimum_quantity'],
            'customer_eligibility' => $data['customer'],
            'customer_id' => $data['customer_id'],
            'applies_product' => $data['product'],
            'product_id' => $productId,
            'usage_limit_number_of_times_use' => isset($data['limit_number_discount']) ? 1 : 0,
            'usage_limit_number' => $data['limit_number_discount'] ,
            'usage_limit_one_user_per_customer' => isset($data['limit_one_use']) ? 1 : 0,
            'usage_limit_new_customer' => isset($data['limit_new_customer']) ? 1 : 0,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => isset($data['status']) && $data['status'] == 'on' ? 1 : 0,
        ]);
    }
}
