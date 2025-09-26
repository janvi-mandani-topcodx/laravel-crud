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
        $items = [];
        foreach ($data['productId'] as $key => $value) {
            $item = [
                'product_id' => $data['productId'][$key],
                'variant_id' => $data['variantId'][$key],
                'quantity' => $data['quantity'][$key],
                'price' => $data['price'][$key],
            ];
            $items[] = $item;
        }
        foreach ($items as $item) {
            $order->orderItems()->create($item);
        }
        $cart = Cart::all();
        foreach ($cart as $item) {
            $item->delete();
        }
        return redirect()->route('order.index');
    }
}
