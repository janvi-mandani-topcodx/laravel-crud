<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDiscount;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    private $OrderRepo;

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
                ->editColumn('name' , function ($order){
                    return $order->user->full_name;
                })
                ->editColumn('total'  ,function ($order) {
                    $total = '';
                    $total .= '$'.$order->total;
                    return $total;
                })
                ->rawColumns(['id'])
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
        $order = Order::with(['orderItems' , 'orderDiscounts'])->find($id);
        $shippingDetails = json_decode($order['shipping_details']);
        $orderItems = $order->orderItems;
        $orderDiscounts = $order->orderDiscounts;
        $totalPrice = 0;
        foreach ($orderItems as $orderItem) {
            $total = $orderItem->quantity * $orderItem->price;
            $totalPrice += $total;
        }
        return view('orders.show', compact('order' , 'shippingDetails' , 'orderItems' , 'orderDiscounts' , 'totalPrice'));
    }

    public function edit(string $id)
    {
        $order = Order::with('orderItems')->find($id);
        $shippingDetails = json_decode($order['shipping_details']);
        $orderDiscounts = $order->orderDiscounts;

        return view('orders.edit', compact('order', 'shippingDetails' , 'orderDiscounts'));
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

    public function orderSearch(Request $request)
    {
        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $products = Product::where('title', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->get();
        }
        else{
            $products = Product::all();
        }
        if ($request->ajax()) {
            $html = '';
            foreach ($products as $product) {
                foreach ($product->productVariants as $productVariant) {
                    $html .= '<div class="row bg-light rounded my-2 border one-product-'.$product->id.'-'.$productVariant->id.'" id="one-product" data-id="'. $product->id .'" data-variant="'.$productVariant->id.'">
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                <img src="'.$product->image_url[0].'" width="100" height="100" class="search-product-image" data-url="'.$product->image_url[0].'">
                                            </div>
                                            <div class="col">
                                                 <p class="search-product-title">'. $product->title.'</p>
                                                 <p class="search-variant-title">Size : '. $productVariant->title.'</p>
                                            </div>
                                            <div class="col">
                                                <p>$</p>
                                                <p class="search-price">'. $productVariant->price .'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                }
            }
            return response()->json(['html' => $html]);
        }
    }

    public function orderItemDelete(Request $request)
    {
        $id = $request->delete_id;
        $orderItems = OrderItem::find($id);
        $orderItems->delete();
        return response()->json(['success' => 'Item deleted']);
    }

    public function  orderItemUpdate(Request $request , string $id)
    {
        $input = $request->all();
        $orderItem = OrderItem::where('order_id', $id)->get();
        $items = [];
        foreach ($input['price'] as $key => $value) {
            $item = [
                'price' => $input['price'][$key],
                'product' => $input['product'][$key],
                'variant' => $input['variant'][$key],
                'quantity' => $input['quantity'][$key],
            ];
            if (isset($input['editId'][$key])) {
                $item['editId'] = $input['editId'][$key];
            }
            $items[] = $item;
        }
        foreach ($items as $item) {
            $orderItems = Arr::except($item, 'editId');
            if(isset($item['editId'])) {
                $updateItems = $orderItem->where('id', $item['editId'])->first();
                $updateItems->order()->update([
                    'total' => $input['total'],
                ]);
                $updateItems->update([
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'product_id' => $item['product'],
                    'variant_id' => $item['variant'],
                ]);
            }
            else {
                OrderItem::create([
                    'order_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'product_id' => $item['product'],
                    'variant_id' => $item['variant'],
                ]);
            }
        }
    }
}
