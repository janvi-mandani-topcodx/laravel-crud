<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGiftCardRequest;
use App\Http\Requests\UpdateGiftCardRequest;
use App\Models\GiftCard;
use App\Models\User;
use App\Repositories\GiftCardRepository;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GiftCardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $giftCardRepo;

    public function __construct(GiftCardRepository $giftCardRepository)
    {
        $this->giftCardRepo = $giftCardRepository;
    }
    public function index(Request $request)
    {
        $discount = GiftCard::all();
        if ($request->ajax()) {
            return DataTables::of(GiftCard::get())
                ->editColumn('customer_id', function ($discount) {
                    return $discount->user ? $discount->user->full_name : '';
                })
                ->editColumn('enabled', function ($discount) {
                    return $discount->enabled == 0 ? 'InActive' : 'Active';
                })
                ->make(true);
        }
        return view('gift_cards.index', compact('discount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gift_cards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateGiftCardRequest $request)
    {
        $input = $request->all();
        $this->giftCardRepo->store($input);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $giftCard = GiftCard::find($id);
        return view('gift_cards.show', compact('giftCard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $giftCard = GiftCard::find($id);
        return view('gift_cards.edit' , compact('giftCard'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGiftCardRequest $request, string $id)
    {
        $input = $request->all();
        $giftCard = GiftCard::find($id);
        $this->giftCardRepo->update($input , $giftCard);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        GiftCard::find($id)->delete();
    }

    public function giftCardUserSearch(Request $request)
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

    public function giftCardCheck(Request $request)
    {
//        $input = $request->all();
//
////        $cartDiscount = CartDiscount::where('code' , $input['discount_code'])->first();
//
//        $voucherDiscount =  new VoucherService();
//        return $voucherDiscount->giftVoucher($input , $giftCode);
    }

}
