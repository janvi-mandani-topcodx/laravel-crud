<?php

namespace App\Repositories;
use App\Models\Cart;
use App\Models\CartDiscount;
use App\Models\GiftCard;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class OrderRepository extends BaseRepository
{
    public function model()
    {
        return Order::class;
    }

    public function store($data)
    {
        $shippingDetails = Arr::only($data, ['first_name' , 'last_name', 'address' , 'state' , 'country']);
        $jsonData = json_encode($shippingDetails);
        $order = Order::create([
            'user_id' => auth()->id(),
            'shipping_details' => $jsonData,
            'delivery' => $data['delivery'],
            'total' => $data['total'],
        ]);
        $this->orderDiscountStore($order , $data);
        $this->orderItemStore($order , $data);
    }

    public function orderItemStore($order , $data)
    {
        foreach ($data['productId'] as $key => $value) {
            $item = [
                'product_id' => $data['productId'][$key],
                'variant_id' => $data['variantId'][$key],
                'quantity' => $data['quantity'][$key],
                'price' => $data['price'][$key],
            ];
            $existingItem = $order->orderItems()->where('product_id', $item['product_id'])->where('variant_id' , $item['variant_id'])->first();

            if ($existingItem) {
                $existingItem->update([
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            } else {
                $order->orderItems()->create($item);
            }
        }
        $cart = Cart::all();
        foreach ($cart as $item) {
            $item->delete();
        }
        $cartDiscounts = CartDiscount::where('user_id' , auth()->id())->get();
        foreach ($cartDiscounts as $cartDiscount) {
            $cartDiscount->delete();
        }
    }

    public  function orderDiscountStore($order , $data)
    {
        foreach ($data['code'] as $key => $value) {
            $item = [
                'code' => $data['code'][$key],
                'type' => $data['type'][$key],
                'amount' => $data['amount'][$key],
                'discount_name' => $data['name'][$key],
            ];

           if($item['discount_name'] == 'gift_card'){
               $order->orderDiscounts()->create($item);
               $giftCard = GiftCard::where('code', $item['code'])->first();
               $giftCard->balance -=  $item['amount'];
               $giftCard->save();
           }
           else{
               $order->orderDiscounts()->create($item);
               if($item['discount_name'] == 'credit') {
                   $user = $order->user;
                   $user->credits -= $item['amount'];
                   $user->save();
               }
           }
        }
    }

    public function update($data, $order){
        $shippingDetails = Arr::only($data, ['first_name' , 'last_name', 'address' , 'state' , 'country']);
        $jsonData = json_encode($shippingDetails);
        $orderUpdate = Arr::only($data , [ 'delivery' , 'total']);
        $orderUpdate['shipping_details'] = $jsonData;
        $order->update($orderUpdate);
    }
}
