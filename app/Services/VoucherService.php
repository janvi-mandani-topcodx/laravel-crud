<?php

namespace App\Services;


use App\Models\CartDiscount;
use App\Models\Order;

class VoucherService
{

    public  function discountVoucher($input , $discount , $cartDiscount)
    {
        if($discount){
           if(!$cartDiscount){
                   if($discount->customer_id == null || $discount->customer_id != auth()->id()){
                       return response()->json([
                           'status' => 'error',
                           'message' => 'You cannot access this card'
                       ]);
                   }
                   if($discount->minimum_requirements == 'quantity amount'){
                       $amount = $discount->minimum_amount;
                       if($amount >= $input['count']){
                           return response()->json([
                               'status' => 'error',
                               'message' => 'enter the quantity amount'
                           ]);
                       }
                   }

                   if($discount->minimum_requirements == 'purchase amount'){
                       $purchaseAmount = $discount->minimum_amount;
                       if($purchaseAmount >= $input['subTotal']){
                           return response()->json([
                               'status' => 'error',
                               'message' => 'enter the purchase amount'
                           ]);
                       }
                   }

                   if($discount->applies_product == 'specific product'){
                       if($discount->product_id != null){
                           $user = auth()->user();
                           $cart = $user->carts->where('product_id' , $discount->product_id)->first();
                           if(!$cart){
                               return response()->json([
                                   'status' => 'error',
                                   'message' => 'product is not found in cart'
                               ]);
                           }
                       }
                   }

                   if($discount->start_date != null){
                       $startDate = $discount->start_date;
                       $endDate = $discount->end_date;
                       $currentDate = date('Y-m-d');

                       if ($currentDate < $startDate) {
                           return response()->json([
                               'status' => 'error',
                               'message' => 'Invalid start date'
                           ]);
                       }
                       if ($endDate != null) {
                           if ($endDate < $startDate) {
                               return response()->json([
                                   'status' => 'error',
                                   'message' => 'Invalid end date1'
                               ]);
                           }
                           if ($currentDate > $endDate) {
                               return response()->json([
                                   'status' => 'error',
                                   'message' => 'Invalid end date2'
                               ]);
                           }
                       }
                   }

                   if($discount->status == 0){
                       return response()->json([
                           'status' => 'error',
                           'message' => 'status is not active'
                       ]);
                   }

                   $order = Order::where('user_id' , auth()->id())->count();
                   if($discount->usage_limit_number_of_times_use == 1 || $discount->usage_limit_one_user_per_customer == 1 || $discount->usage_limit_new_customer == 1){
                       if($discount->usage_limit_number_of_times_use == 1){
                           if($order >= $discount->usage_limit_number){
                               return response()->json([
                                   'status' => 'error',
                                   'message' => 'you can not use this discount'
                               ]);
                           }
                           else{
                               CartDiscount::create([
                                   'user_id'=>auth()->id(),
                                   'amount' => $discount->amount,
                                   'code' => $discount->code,
                                   'type' => $discount->type,
                               ]);
                               return response()->json([
                                   'status' => 'success',
                                   'discount_amount' => $discount->amount,
                                   'code' => $discount->code,
                                   'type' => $discount->type,
                               ]);
                           }
                       }

                       if($discount->usage_limit_one_user_per_customer == 1){
                           if($order >= 1){
                               return response()->json([
                                   'status' => 'error',
                                   'message' => 'you are only one time use this discount'
                               ]);
                           }
                           else{
                               CartDiscount::create([
                                   'user_id'=>auth()->id(),
                                   'amount' => $discount->amount,
                                   'code' => $discount->code,
                                   'type' => $discount->type,
                               ]);
                               return response()->json([
                                   'status' => 'success',
                                   'discount_amount' => $discount->amount,
                                   'code' => $discount->code,
                                   'type' => $discount->type,
                               ]);
                           }
                       }

                       if($discount->usage_limit_new_customer == 1){
                           if($order >= 1){
                               return response()->json([
                                   'status' => 'error',
                                   'message' => 'you are not new customer'
                               ]);
                           }
                           else{
                               CartDiscount::create([
                                   'user_id'=>auth()->id(),
                                   'amount' => $discount->amount,
                                   'code' => $discount->code,
                                   'type' => $discount->type,
                               ]);
                               return response()->json([
                                   'status' =>'success',
                                   'discount_amount' => $discount->amount,
                                   'code' => $discount->code,
                                   'type' => $discount->type,
                               ]);
                           }
                       }
                   }

           }
           else if($cartDiscount != null && $cartDiscount->code == $input['discount_code']){
               return response()->json([
                   'status' => 'warning',
                   'message' => 'discount is already added',
                   'discount_amount' => $discount->amount,
                   'code' => $discount->code,
                   'type' => $discount->type,
               ]);
           }
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'discount code does not match'
            ]);
        }
    }

}
