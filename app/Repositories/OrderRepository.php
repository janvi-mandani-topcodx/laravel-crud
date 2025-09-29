<?php

namespace App\Repositories;
use App\Models\Cart;
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
        $this->orderItemStore($order , $data);
        return redirect()->route('order.index');
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
    }

    public function update($data, $order){
        $shippingDetails = Arr::only($data, ['first_name' , 'last_name', 'address' , 'state' , 'country']);
        $jsonData = json_encode($shippingDetails);
        $orderUpdate = Arr::only($data , [ 'delivery' , 'total']);
        $orderUpdate['shipping_details'] = $jsonData;
        $order->update($orderUpdate);
    }
}
