<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartDiscount;
use App\Models\GiftCard;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(Request $request){
        $html = '';
        $discountHtml = '';
        $input = $request->all();
        $userId = auth()->id();
        $editCart = Cart::where('user_id',$userId)->where('product_id',$input['product_id'])->where('variant_id' , $input['variant_id'])->first();
        if($editCart){
            $editCart->quantity = $editCart->quantity + 1;
            $editCart->save();
            return response()->json([
                'quantity' => $editCart->quantity ,
                'cartId' =>$editCart->id,
                ]);
        }
        else{

            $cart = Cart::create([
                'user_id' => $userId,
                'product_id' => $input['product_id'],
                'variant_id' => $input['variant_id'],
                'quantity' => $input['quantity'],
            ]);
            $existingCartCount = Cart::where('user_id' , $userId)->count();
//            $existingCartCount = auth()->id()->carts()->count();

//            $discount = CartDiscount::where('user_id' , $userId)->get();

            $html .= '
                    <div class="row my-3 bg-light cart-'.$cart->id.' cart-product-'.$input['product_id'].'" data-product="'.$input['product_id'].'" data-variant="'.$input['variant_id'].'" data-cart="'.$cart->id.'">
                        <div class="col">
                              <img class="card-img-top rounded" src="'.$input['image'].'" alt="Card image cap" style="height: 100px; width: 100px;">
                        </div>
                   <div class="col">
                             <div class="row mb-2">
                                <span class="col text-muted">'.$input['title'].'</span>
                            </div>
                             <div class="row">
                                <span class="col">Size : '.$input['size'].'</span>
                            </div>
                             <div class="d-flex align-items-end justify-content-around pt-2 " data-product="'.$input['product_id'].'" data-variant="'.$input['variant_id'].'">
                                <span class="fs-4 decrement decrement-cart-'.$input['product_id'].'-'.$input['variant_id'].'">-</span>
                                <span class="fs-5 quantity-cart">1</span>
                                <span class="fs-4 increment increment-cart-'.$input['product_id'].'-'.$input['variant_id'].'">+</span>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <button type="button" class="btn-close close-product dlt-'.$cart->id.'" aria-label="Close" data-id="'.$cart->id.'" data-product="'.$input['product_id'].'"></button>
                            </div>
                              <div class="pt-5 d-flex">
                               <p>$</p>
                               <span class="cart-price">'.$input['price'].'</span>
                            </div>
                        </div>
                    </div>
                ';
//            $discountHtml .= '
//                     <div class="d-flex justify-content-between discount-apply credit">
//                          <label>credit : '.$discount->code.'</label>
//                          <div class="d-flex">
//                               <div class="d-flex">
//                                    <span>$</span>
//                               </div>
//                                <span class="discount-show" data-type="'.$discount->type.'" data-code="'.$discount->code.'" data-name="'.$discount->discount_name.'">'.$discount->amount.'</span>
//                          </div>
//                     </div>
//                ';
            if ($existingCartCount < 1) {
                $html .= '
                    <div class="position-absolute  w-100" style="bottom: 20px; left:0;">
                          <div class="d-flex justify-content-between">
                            <label>Sub Total</label>
                            <div class="d-flex">
                                <span>$</span>
                                <span class="subtotal"></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <label>Total</label>
                            <div class="d-flex">
                                <span>$</span>
                                <span class="total"></span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <div class="btn btn-success w-75 checkoutBtn">Checkout</div>
                        </div>
                    </div>
            ';
            }

            return response()->json(['html' => $html , 'variant' => $input['variant_id'] , 'discount' => $discountHtml]);
        }
    }

    public function updateCart(Request $request)
    {
        $userId = auth()->id();
        $input = $request->all();
        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $input['product_id'])
            ->where('variant_id', $input['variant_id'])
            ->first();
        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
    //            if($request->subtotal !=0){
    //                $credit  = CartDiscount::where('user_id' , auth()->id())->where('discount_name' , 'credit')->first();
    //                $isCredit = auth()->user()->credits;
    //                $discountHtml = '';
    //                if($credit == null && $isCredit != 0){
    //                    $discount = CartDiscount::create([
    //                        'user_id'=>auth()->id(),
    //                        'amount' => min(auth()->user()->credits , $request->subtotal),
    //                        'code' => 'credit',
    //                        'type' => 'fixed',
    //                        'discount_name' => 'credit',
    //                    ]);
    //                    $discountHtml .= '
    //                     <div class="d-flex justify-content-between discount-apply credit">
    //                          <label>credit : '.$discount->code.'</label>
    //                          <div class="d-flex">
    //                               <div class="d-flex">
    //                                    <span>$</span>
    //                               </div>
    //                                <span class="discount-show" data-type="'.$discount->type.'" data-code="'.$discount->code.'" data-name="'.$discount->discount_name.'">'.$discount->amount.'</span>
    //                          </div>
    //                     </div>
    //                ';
    //                    return response()->json(['discount' => $discountHtml]);
    //                }
    //                else{
    //                    return response()->json([
    //                        'status' => false,
    //                    ]);
    //                }
    //            }
            return response()->json(['message' => 'Quantity updated']);
        }

        return response()->json(['message' => 'Item not found'], 404);
    }

    public function cartDelete(Request $request)
    {
        $id = $request->delete_id;
        $cart = Cart::find($id);
        $cart->delete();
        return response()->json(['success' => 'Item deleted']);
    }

    public function cartAddButton(Request $request)
    {
        $input = $request->all();
        $variantId = $input['variant'];
        $cart = Cart::where('variant_id' , $variantId)->first();
        if($cart){
           return response()->json([
               'status' => true,
               'quantity' => $cart['quantity']
           ]);
        }
        else{
            return response()->json([
                'status' => false,
//                'quantity' => $cart['quantity']
            ]);
        }
    }

    public function cartDiscountDelete(Request $request)
    {
        $id = $request->delete_id;
        $cartDiscount = CartDiscount::find($id);
        $cartDiscount->delete();
        return response()->json(['success' => 'discount deleted']);
    }

    public  function CreditStoreCart(Request $request)
    {
        if($request->subtotal != 0){
            $credit  = CartDiscount::where('user_id' , auth()->id())->where('discount_name' , 'credit')->first();
               $userCredit = auth()->user()->credits;
               $discountHtml = '';
               if($credit){
                   $credit->amount = min(auth()->user()->credits , $request->subtotal);
                   $credit->save();
                   return response()->json([
                       'amount' => $credit->amount,
                   ]);
               }
               if(!$credit && $userCredit != 0){
                   $discount = CartDiscount::create([
                       'user_id'=>auth()->id(),
                       'amount' => min(auth()->user()->credits , $request->subtotal),
                       'code' => 'credit',
                       'type' => 'fixed',
                       'discount_name' => 'credit',
                   ]);
                   $discountHtml .= '
                     <div class="d-flex justify-content-between discount-apply credit">
                          <label>credit : '.$discount->code.'</label>
                          <div class="d-flex">
                               <div class="d-flex">
                                    <span>$</span>
                               </div>
                                <span class="discount-show" data-type="'.$discount->type.'" data-code="'.$discount->code.'" data-name="'.$discount->discount_name.'">'.$discount->amount.'</span>
                          </div>
                     </div>
                ';
                   return response()->json(['discount' => $discountHtml , 'amount' => $discount->amount]);
               }
        }
    }

    public function giftCardUpdateCart(Request $request)
    {
        $credit  = CartDiscount::where('user_id' , auth()->id())->where('code' , $request->giftCard)->first();
        $giftCard = GiftCard::where('code' , $request->giftCard)->first();
        $credit->amount = min($giftCard->balance , $request->subtotal);
        $credit->save();
        return response()->json([
            'amount' => $credit->amount,
        ]);
    }
}
