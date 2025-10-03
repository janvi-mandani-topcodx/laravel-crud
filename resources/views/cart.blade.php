    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasWithBothOptionsLabel">Cart</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if(isset($carts))
                <div id="allCartData" style="overflow: auto; height: 85%; overflow-x: hidden;">
                    @foreach($carts as $cart)
                        <div class="row my-3 bg-light cart-{{$cart->id}} cart-product-{{$cart->product->id}}" data-product="{{$cart->product->id}}" data-variant="{{$cart->variant->id}}" data-cart="{{$cart->id}}">
                            <div class="col">
                                <img class="card-img-top rounded" src="{{$cart->product->image_url[0]}}" alt="Card image cap" style="height: 100px; width: 100px;">
                            </div>
                            <div class="col">
                                <div class="row mb-2">
                                    <span class="col text-muted">{{$cart->product->title}}</span>
                                </div>
                                <div class="row">
                                    <span class="col">Size : {{$cart->variant->title}}</span>
                                </div>
                                <div class=" d-flex align-items-end justify-content-around pt-2 " data-product="{{$cart->product->id}}" data-variant="{{$cart->variant->id}}" >
                                    <span class="fs-4 decrement decrement-cart-{{$cart->product->id}}-{{$cart->variant->id}}">-</span>
                                    <span class="fs-5 quantity-cart">{{$cart->quantity}}</span>
                                    <span class="fs-4 increment increment-cart-{{$cart->product->id}}-{{$cart->variant->id}}">+</span>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="row">
                                    <button type="button" class="btn-close close-product dlt-{{$cart->id}}" aria-label="Close" data-product="{{$cart->product->id}}" data-id="{{$cart->id}}"></button>
                                </div>
                                <div class="pt-5 d-flex">
                                    <p>$</p>
                                    <p class="cart-price">{{$cart->variant->price}}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                        <div class="position-absolute w-100 px-2" style="bottom: 20px; left:0;">

                           <div class="discount-div">
                               <div class="d-flex justify-content-between dis gap-2">
                                   <input type="text" id="discountCode" name="discount_code" class="discount-code form-control w-75">
                                   <button class="btn btn-success" id="discountApply">Apply</button>
                               </div>
                               <div class="voucher-error text-danger"></div>
                           </div>


                            <div class="d-flex justify-content-between my-2" id="subtotal">
                                <label>Subtotal</label>
                                <div class="d-flex">
                                    <span>$</span>
                                    <span class="subtotal"></span>
                                </div>
                            </div>
                            @php
                                $discounts = \App\Models\CartDiscount::where('user_id' , auth()->id())->get();
                                $credit = \App\Models\User::where('id' , auth()->id())->first();
                            @endphp

                            @if($credit->credits != null || $credit->credits != 0)
                                <div class="creditApply d-flex justify-content-between my-2">
                                    <label>Credit</label>
                                    <div class="d-flex">
                                        <span>$</span>
                                        <span class="credit">{{$credit->credits}}</span>
                                    </div>
                                </div>
                            @endif
                            <div class="discountData my-2">
                                @if($discounts)
                                   @foreach($discounts as $discount)
                                       @if($discount->discount_name != 'credit')
                                            @if($discount->type == 'fixed')
                                                <div class="d-flex justify-content-between discount-apply {{$discount->discount_name == 'gift_card' ? 'gift-card' : 'discount-data'}}">
                                                    <label>{{$discount->discount_name == 'gift_card' ? 'Gift card' : $discount->discount_name}} : {{$discount->code}}</label>
                                                    <div>
                                                        <div class="d-flex">
                                                            <span>$</span>
                                                        </div>
                                                        <span class="discount-show" data-type="{{$discount->type}}" data-code="{{$discount->code}}" data-name="{{$discount->discount_name}}">{{$discount->amount}}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex justify-content-between discount-apply {{$discount->discount_name == 'gift_card' ? 'gift-card' : 'discount-data'}}">
                                                    <label>{{$discount->discount_name == 'gift_card' ? 'Gift card' : $discount->discount_name}} : {{$discount->code}}</label>
                                                    <div>
                                                        <div class="d-flex">
                                                            <span class="discount-show" data-type="{{$discount->type}}" data-code="{{$discount->code}}" data-name="{{$discount->discount_name}}">{{$discount->amount}}</span>
                                                            <span>%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                   @endforeach
                                @endif
                            </div>
                            <div class="gift-card-data">

                            </div>

                            <div class="d-flex justify-content-between my-2">
                                <label>Total</label>
                                <div class="d-flex">
                                    <span>$</span>
                                    <span class="total"></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div class="btn btn-success w-100 checkoutBtn">Checkout</div>
                            </div>
                        </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function creditStore(){
                let subtotalText = $('.subtotal').text();
                let mainTotal = subtotalText;
                // let credit = $('.credit').text();
                // if(credit != null) {
                //     console.log(credit)
                //     console.log(subtotalText)
                //     if(credit <= subtotalText){
                //         mainTotal =  mainTotal - credit;
                //     }
                //     else{
                //         mainTotal = mainTotal;
                //         $('.credit').text(mainTotal);
                //     }
                // }
                // else{
                //     mainTotal = mainTotal;
                // }
                // if(credit != null ){
                    $.ajax({
                        url: route('credit.store.cart'),
                        type: "GET",
                        data: {
                            subtotal : subtotalText,
                        },
                        success: function (response) {

                        }
                    });
                // }
            }
            creditStore();
            function count() {
                let totalCount = 0;
                $('.quantity-cart').each(function () {
                    let qty = parseInt($(this).text());
                    totalCount += qty;
                });
                $('.count').text(totalCount);
            }

            function updateTotal() {
                let totalPrice = 0;
                $('.quantity-cart').each(function () {
                    let quantity = parseFloat($(this).text());
                    console.log(quantity)
                    let price = $(this).parents('.row').find('.cart-price').text();
                    console.log(price)
                    let total = quantity * price;
                    totalPrice += total;
                });

                $('.total').text(totalPrice)
                $('.subtotal').text(totalPrice)
                $('.total-checkout').text(totalPrice)
                $('.subtotal-checkout').text(totalPrice)
                console.log($('.subtotal').text() == 0)
                if($('.subtotal').text() == 0){
                    $('.checkoutBtn').hide();
                    $('.discount-div').hide();
                }
                else{
                    $('.checkoutBtn').show();
                    $('.discount-div').show();
                }
            }


            function discountAdd() {
                let subtotalText = $('.subtotal').text();
                let mainTotal = subtotalText;
                let credit = $('.credit').text();
                if(credit != null) {
                    if(credit <= subtotalText){
                        mainTotal = mainTotal - credit;
                    }
                    else{
                        mainTotal = mainTotal - mainTotal;
                        $('.credit').text(mainTotal);
                    }
                }
                else{
                    mainTotal = mainTotal;
                }


                if ($('.discountData').text() != null) {
                    $('.gift-card').each(function() {
                        let discount = $(this);
                        let amount = discount.find('.discount-show').text();
                        console.log("main = " + mainTotal)
                        if(amount <= subtotalText){
                            mainTotal = mainTotal - amount;
                            console.log("reree" + mainTotal)
                        }
                        else{
                            discount.find('.discount-show').text(mainTotal)
                            mainTotal = mainTotal - mainTotal;
                        }
                        if (mainTotal < 0) {
                            mainTotal = 0;
                        }
                    });

                    $('.discount-data').each(function() {
                        let discount = $(this);
                        let type = discount.find('.discount-show').data('type');
                        let amount = discount.find('.discount-show').text();

                        if (type === 'percentage') {
                            let discountAmount = mainTotal * (amount / 100);
                            mainTotal = mainTotal - discountAmount;
                        } else if (type === 'fixed') {
                            mainTotal = mainTotal - amount;
                        }
                        console.log("discountTotal = " + mainTotal )
                        if (mainTotal < 0) {
                            mainTotal = 0;
                        }
                    });


                    $('.total').text(mainTotal);
                    $('.total-checkout').text(mainTotal);
                }
            }

            updateTotal();
            discountAdd();

            $(document).on('click', '.close-product', function () {
                let deleteId = $(this).data('id');
                let productId = $(this).data('product');
                let cartId = $(this).data('id');
                let row = $(this).closest('.cart-' + cartId);
                let row1 = $('.checkoutAllItems').find('.dlt-' + cartId).parents('.cartData');

                $.ajax({
                    url: route('delete.cart'),
                    type: "GET",
                    data: {
                        delete_id: deleteId
                    },
                    success: function (response) {
                        if (response.success) {
                            row.remove();
                            row1.remove()
                            $('.product-' + productId).find('#addToCart').show();
                            $('.product-' + productId).find('#incrementDecrement').hide();
                            count();
                            updateTotal();
                            discountAdd()
                        }
                    },
                });
            });
            $(document).on('click', '#discountApply', function () {
                let discountCode = $(this).parents('.dis').find('#discountCode').val();
                let count = $('.count').text();
                let subTotal = $('#subtotal').find('.subtotal').text();
                let total = $('.total').text();

                $.ajax({
                    url: "{{route('discount.code.check')}}",
                    type: "POST",
                    dataType: 'json',
                    data: {
                        discount_code: discountCode,
                        count: count,
                        subTotal: subTotal,
                        total : total,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        $('#discountCode').val('');

                        if (response.status == 'error') {
                            $('.voucher-error').text(response.message)
                        }
                        else if(response.status == 'success' && response.discount_amount){
                            if ($('.discountData').text('')) {
                                const discount = `
                                <div class="d-flex justify-content-between discount-apply discount-data">
                                    <label>Discount : ${response.code}</label>
                                    <div class="d-flex">
                                        <span>${response.type == 'fixed' ? '$' : ''}</span>
                                        <span class="discount-show" data-type="${response.type}" data-code="${response.code}">${response.discount_amount}</span>
                                        <span>${response.type == 'percentage' ? '%' : ''}</span>
                                    </div>
                                </div>
                            `;
                                $('.voucher-error').text('')
                                $('.discountData').append(discount)
                            }
                        }

                        if(response.status == 'warning'){
                            $('.voucher-error').text(response.message)
                            const discount = `
                                <div class="d-flex justify-content-between discount-apply discount-data">
                                    <label>Discount : ${response.code}</label>
                                    <div class="d-flex">
                                        <span>$</span>
                                        <span class="discount-show" data-type="${response.type}" data-code="${response.code}">${response.discount_amount}</span>
                                    </div>
                                </div>
                            `;
                            $('.discountData').append(discount)
                        }

                        if(response.status == 'success'  &&  response.discount == 'gift card'){
                            const giftCardDiscount = `
                                <div class="d-flex justify-content-between discount-apply gift-card">
                                    <label>Gift Card : ${response.code}</label>
                                    <div class="d-flex">
                                        <span>$</span>
                                        <span class="discount-show" data-type="fixed" data-code="${response.code}">${response.balance}</span>
                                    </div>
                                </div>
                            `;
                            if ($('.gift-card-data').text('')) {
                                $('.voucher-error').text('')
                                $('.gift-card-data').append(giftCardDiscount)
                            }
                        }
                        updateTotal();
                        discountAdd();
                    },
                });
            });

            $(document).on('click' , '.close-discount' , function (){
                let deleteId = $(this).data('id');
                $.ajax({
                    url: route('delete.cart.discount'),
                    type: "GET",
                    data: {
                        delete_id: deleteId
                    },
                    success: function (response) {
                        if (response.success) {
                            $('.discountData').remove();
                            count();
                            updateTotal();
                            discountAdd()
                        }
                    },
                });
            })
        });
    </script>
