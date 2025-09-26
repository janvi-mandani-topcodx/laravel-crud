<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    private $orderRepo;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->OrderRepo = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Order::get())
                ->editColumn('created_at' , function ($order) {
                    return $order->created_at->format('d-m-Y');
                })
                ->editColumn('name' , function ($order) {
                    $name = '';
                    $name .= '<a href="'. route('order.show' , $order->id) .'" data-id=' . $order->id .'>'.$order->user->full_name.' </a>';
                    return $name;
                })
                ->editColumn('total'  ,function ($order) {
                    $total = '';
                    $total .= '$'.$order->total;
                    return $total;
                })
                ->rawColumns(['name'])
                ->make(true);
        }
        return view('orders.index');
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CheckoutRequest $request)
    {
        $input = $request->all();
        $this->OrderRepo->store($input);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);
        $shippingDetails = json_decode($order['shipping_details']);
        $orderItems = OrderItem::with(['product' , 'variant'])->where('order_id', $id)->get();
        return view('orders.show', compact('order' , 'shippingDetails' , 'orderItems'));
    }

    public function edit(string $id)
    {
        $order = Order::with('orderItems')->find($id);
        $shippingDetails = json_decode($order['shipping_details']);
        return view('orders.edit', compact('order', 'shippingDetails'));
    }

    public function update(Request $request, string $id)
    {
        $input = $request->all();
        $order =  Order::find($id);
        $this->OrderRepo->update($input,$order);

    }

    public function destroy(string $id)
    {
        $order = Order::find($id);
        $order->delete();
    }
}
