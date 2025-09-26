<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class CheckoutController extends Controller
{


    public function checkout()
    {
        $carts = Cart::all();
        return view('checkout.index', compact('carts'));
    }

//    public function orderIndex(Request $request)
//    {
//        if ($request->ajax()) {
//            return DataTables::of(Order::get())
//                ->make(true);
//        }
//        return view('orders.index');
//    }
//    public function orderCreate(Request $request)
//    {
//        $input = $request->all();
//        $carts = Cart::where('user_id', auth()->id())->get();
//        $this->OrderRepo->store($input , $carts);
//    }
//
//    public function orderShow($id)
//    {
//        $orders = Order::find($id);
//        return view('orders.show', compact('orders'));
//    }
}
