<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Cart;
use App\Models\CartDiscount;
use App\Models\Discount;
use App\Models\GiftCard;
use App\Models\Product;
use App\Models\User;
use App\Repositories\DiscountRepository;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $discountRepo;

    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discountRepo = $discountRepository;
    }
    public function index(Request $request)
    {
        $discount = Discount::all();
        if ($request->ajax()) {
            return DataTables::of(Discount::get())
                ->editColumn('customer_id', function ($discount) {
                    return $discount->user ? $discount->user->full_name : '';
                })
                ->editColumn('product_id', function ($discount) {
                    return $discount->product ? $discount->product->title : '';
                })
                ->editColumn('end_date', function ($discount) {
                    return $discount->end_date == null ? null : $discount->end_date;
                })
                ->editColumn('status', function ($discount) {
                    return $discount->status == 0 ? 'InActive' : 'Active';
                })
                ->make(true);
        }
        return view('discounts.index', compact('discount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateDiscountRequest $request)
    {
        $input = $request->all();
        $this->discountRepo->store($input);
        return redirect()->route('discounts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $discount =  Discount::find($id);
        return view('discounts.show' , compact('discount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $discount = Discount::with('product' , 'user')->find($id);
        return view('discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, string $id)
    {
        $input = $request->all();
        $discountData  = Discount::find($id);
        $this->discountRepo->update($input , $discountData);
        return redirect()->route('discounts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Discount::find($id)->delete();
    }

    public function productSearch(Request $request)
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
                                            <div class="col d-flex ">
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

    public function userSearch(Request $request)
    {
        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $users = User::where('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->get();
        }
        else{
            $users = User::all();
        }
        if ($request->ajax()) {
            $html = '';
            foreach ($users as $user) {
                    $html .= '<div class="row bg-light rounded my-2 border one-user-'.$user->id.'" id="one-user" data-id="'. $user->id .'" >
                                    <div class="col">
                                        <div class="row">
                                            <div class="col">
                                                 <p class="name">'. $user->first_name.' '.$user->last_name.'</p>
                                            </div>
                                            <div class="col">
                                                <p class="email">'. $user->email .'</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
            }
            return response()->json(['html' => $html]);
        }
    }

    public function discountCodeCheck(Request $request)
    {
            $input = $request->all();
            $discount = Discount::where('code' , $input['discount_code'])->first();
            $cartDiscount = CartDiscount::where('code' , $input['discount_code'])->first();
            $giftCard = GiftCard::where('code' , $input['discount_code'])->first();

            $voucherDiscount =  new VoucherService();
            if($discount){
                return $voucherDiscount->discountVoucher($input , $discount , $cartDiscount);
            }
            else if($giftCard){
                return  $voucherDiscount->giftVoucher($input , $giftCard);
            }
            else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Discount code not found'
                ]);
            }
    }
}
