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
            'minimum_amount' => $data['minimum_purchase'],
            'customer' => $data['customer'],
            'user_id' => $data['customer_id'],
            'product' => $data['product'],
            'product_id' => $data['product_id'],
            'discount_apply_type' => $data['limit_number'] ?? null,
            'discount_type_number' => $data['limit_discount'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']== 'on' ? 1 : 0,
        ]);
        return redirect()->route('discounts.index');
    }


    public function update($data , $discountData)
    {
        $discountData->update([
            'code' => $data['code'],
            'amount' => $data['value'],
            'type' => $data['type'],
            'minimum_requirements' => $data['requirement'],
            'minimum_amount' => isset($data['minimum_purchase']) ? $data['minimum_purchase'] : $data['minimum_quantity'],
            'customer' => $data['customer'],
            'user_id' => $data['customer_id'],
            'product' => $data['product'],
            'product_id' => $data['product_id'],
            'discount_apply_type' => $data['limit_number'],
            'discount_type_number' => $data['limit_discount'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $data['status']== 'on' ? 1 : 0,
        ]);
    }
}
