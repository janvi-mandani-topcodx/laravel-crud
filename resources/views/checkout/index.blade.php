@extends('layout')
@section('content')
<div class="container py-5 h-100">
    <div class="row  h-100">
        <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Shipping Details</h3>
        <div class="col-6">
            <section class="vh-100 gradient-custom my-5">
                <div class="" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                       <form method="post">
                           @include('checkout.fields')
                       </form>
                    </div>
                </div>
            </section>
        </div>
        <div class="col-6 h-100">
            <section class="vh-100 gradient-custom my-5">
                <div class="card shadow-2-strong card-registration h-75" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5 checkoutAllItems" id="checkoutAllItems">
                        <div id="allCheckoutDiv" style="overflow: auto; height: 88%; overflow-x: hidden">
                            @foreach($carts as $cart)
                                <div class="row my-3 bg-light cart-{{$cart->id}} cartData" data-product="{{$cart->product->id}}" data-variant="{{$cart->variant->id}}" data-cart="{{$cart->id}}">
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
                                            <span class="fs-4 decrement-checkout decrement-checkout-{{$cart->product->id}}-{{$cart->variant->id}}">-</span>
                                            <span class="fs-5 quantity-checkout">{{$cart->quantity}}</span>
                                            <span class="fs-4 increment-checkout increment-checkout-{{$cart->product->id}}-{{$cart->variant->id}}">+</span>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="row">
                                            <button type="button" class="btn-close close-product-checkout dlt-{{$cart->id}}" aria-label="Close" data-product="{{$cart->product->id}}" data-id="{{$cart->id}}"></button>
                                        </div>
                                        <div class="pt-5 d-flex">
                                            <p>$</p>
                                            <p class="cart-price">{{$cart->variant->price}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                            <div class="position-absolute w-100" style="bottom: 20px; left:20px; padding-right: 40px;">
                                <div class="d-flex justify-content-between dis gap-2 my-2">
                                    <input type="text" id="discountCode" name="discount_code" class="discount-code form-control w-75">
                                    <button class="btn btn-success" id="discountApplyCheckout">Apply</button>
                                </div>
                                <div class="voucher-error text-danger"></div>
                                <div class="d-flex justify-content-between">
                                    <label>Subtotal</label>
                                    <div class="d-flex">
                                        <span>$</span>
                                        <span class="subtotal-checkout" id="totalAmount"></span>
                                    </div>
                                </div>
                                <div></div>
                                <div class="discountData">
                                    <div class="my-2">
                                        @if($discounts)
                                            @foreach($discounts as $discount)
                                                    @if($discount->type == 'fixed')
                                                        <div class="d-flex justify-content-between all-discounts-apply {{$discount->discount_name == 'gift_card' ? 'gift-card' : ($discount->discount_name == 'discount' ? 'discount-data' :'credit-checkout')}}">
                                                            <label>{{$discount->discount_name == 'gift_card' ? 'Gift card' : $discount->discount_name}} : {{$discount->code}}</label>
                                                            <div>
                                                                <div class="d-flex">
                                                                    <span>$</span>
                                                                    <span class="discount-show-checkout" data-type="{{$discount->type}}" data-code="{{$discount->code}}" data-name="{{$discount->discount_name}}">{{$discount->amount}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="d-flex justify-content-between all-discounts-apply {{$discount->discount_name == 'gift_card' ? 'gift-card' : ($discount->discount_name == 'discount' ? 'discount-data' :'credit-checkout')}}">
                                                            <label>{{$discount->discount_name == 'gift_card' ? 'Gift card' : $discount->discount_name}} : {{$discount->code}}</label>
                                                            <div>
                                                                <div class="d-flex">
                                                                    <span class="discount-show-checkout" data-type="{{$discount->type}}" data-code="{{$discount->code}}" data-name="{{$discount->discount_name}}">{{$discount->amount}}</span>
                                                                    <span>%</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="gift-card-data">

                                </div>
                                <div class="d-flex justify-content-between">
                                    <label>Total</label>
                                    <div class="d-flex">
                                        <span>$</span>
                                        <span class="total-checkout totalPrice" id="totalAmount"></span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function count() {
                let totalCount = 0;
                $('.quantity-cart').each(function() {
                    let qty = parseInt($(this).text());
                    totalCount += qty;
                });
                $('.count').text(totalCount);
            }

            function updateTotal(){
                let totalPrice = 0;
                $('.quantity-cart').each(function () {
                    let quantity = parseFloat($(this).text());
                    let price = $(this).parents('.row').find('.cart-price').text();
                    console.log("price" + price)
                    let total = quantity * price;
                    totalPrice += total;
                });
                console.log(totalPrice)
                console.log( $('.total-checkout'))
                $('.total-checkout').text(totalPrice)
                $('.subtotal-checkout').text(totalPrice)
                $('.total').text(totalPrice)
                $('.subtotal').text(totalPrice)

                let subtotal = $('.subtotal-checkout').text();

                $.ajax({
                    url: route('credit.store.cart'),
                    type: "GET",
                    dataType: 'json',
                    data: {
                        subtotal : subtotal,
                    },
                    success: function (response) {
                        console.log(response)
                        if(response.discount){
                            console.log($('.offcanvas-body').find('.discountData'))
                            $('.offcanvas-body').find('.discountData').append(response.discount)
                        }
                        else{
                            $('.credit-checkout').find('.discount-show-checkout').text(response.amount);
                            $('.credit').find('.discount-show').text(response.amount)
                        }
                        discountAdd()
                    }
                });
                giftCardUpdate();
            }

            function giftCardUpdate(){
                let subtotal = $('.subtotal-checkout').text();
                let credit =  $('.credit-checkout').find('.discount-show-checkout').text();
                let total = 0;
                if(credit){
                    total = parseInt(subtotal) - parseInt(credit)
                }
                else{
                    total = subtotal
                }
                let giftCard = $('.gift-card').find('.discount-show-checkout').data('code');
                $('.gift-card').addClass('d-flex');
                $('.gift-card').show();
                $('.discount-data').addClass('d-flex');
                $('.discount-data').show();
                if(giftCard && total > 0){
                    $.ajax({
                        url: route('gift-card.update.cart'),
                        type: "GET",
                        dataType: 'json',
                        data: {
                            subtotal : total,
                            giftCard : giftCard,
                        },
                        success: function (response) {
                            console.log("Response...... = ", response);
                            $('.gift-card').find('.discount-show').text(response.amount);
                            $('.gift-card').find('.discount-show-checkout').text(response.amount);
                            discountAdd()
                        }
                    });
                }
                else{
                    $('.gift-card').removeClass('d-flex');
                    $('.gift-card').find('.discount-show-checkout').text('0')
                    $('.gift-card').find('.discount-show').text('0')
                    $('.gift-card').hide();
                    $('.discount-data').removeClass('d-flex');
                    $('.discount-data').hide();
                }
            }

            function discountAdd() {

                if ($('.discountData').text() != null) {
                    let subtotalText = $('.subtotal-checkout').text();
                    let mainTotal = subtotalText;
                    $('.credit-checkout').each(function() {
                        let credit = $(this);
                        let amount = credit.find('.discount-show-checkout').text();
                        console.log("amount  - " + amount)
                        console.log("mainTotal  - " + mainTotal)
                        if(amount != null) {
                            if(amount <= subtotalText){
                                mainTotal = mainTotal - amount;
                                console.log("amount = " + mainTotal)
                            }
                            else{
                                mainTotal = mainTotal - mainTotal;
                                $('.discount-show-checkout').text(mainTotal);
                            }
                        }
                        else{
                            mainTotal = mainTotal;
                        }

                    });
                    console.log("mainAmount = " + mainTotal)
                    $('.gift-card').each(function() {
                        let discount = $(this);
                        let amount = discount.find('.discount-show-checkout').text();
                        console.log("main = " + mainTotal)
                        if(amount <= subtotalText){
                            mainTotal = mainTotal - amount;
                            console.log("reree" + mainTotal)
                        }
                        else{
                            discount.find('.discount-show-checkout').text(mainTotal)
                            mainTotal = mainTotal - mainTotal;
                        }
                        if (mainTotal < 0) {
                            mainTotal = 0;
                        }
                    });
                    if(mainTotal == 0){
                        $('.discount-data').removeClass('d-flex');
                        $('.discount-data').find('.discount-show-checkout').text('0');
                        $('.discount-data').hide()
                    }

                    $('.discount-data').each(function() {
                        let discount = $(this);
                        let type = discount.find('.discount-show-checkout').data('type');
                        let amount = discount.find('.discount-show-checkout').text();

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

            $(document).on('click', '#discountApplyCheckout', function () {
                let discountCode = $(this).parents('.dis').find('#discountCode').val();
                let count = $('.count').text();
                let subTotal = $('#subtotal').find('.subtotal').text();
                let total = $('.total-checkout').text();
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
                                    <span class="discount-show-checkout" data-type="${response.type}" data-code="${response.code}">${response.discount_amount}</span>
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
                                    <span class="discount-show-checkout" data-type="${response.type}" data-code="${response.code}">${response.discount_amount}</span>
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
                                    <span class="discount-show-checkout" data-type="fixed" data-code="${response.code}">${response.balance}</span>
                                </div>
                            </div>
                        `;
                            if ($('.gift-card-data').text('')) {
                                $('.voucher-error').text('')
                                $('.gift-card-data').append(giftCardDiscount)

                            }
                        }
                        updateTotal()
                        discountAdd()
                    },
                });
            });


            function allDecrement(quantity ,productId , variantId){
                var currentQuantity = parseInt(quantity.text());
                if(currentQuantity > 1){
                    var newQuantity = currentQuantity - 1;
                    quantity.text(newQuantity);
                    $('.decrement-card-'+ productId +'-'+ variantId).siblings('.quantity').text(newQuantity);
                    $('.decrement-checkout-'+ productId +'-'+ variantId).siblings('.quantity-checkout').text(newQuantity);
                    $('.decrement-cart-'+ productId +'-'+ variantId).siblings('.quantity-cart').text(newQuantity);
                    updateQuantity(productId, variantId , newQuantity)
                }
            }

            function  allIncrement(quantity ,productId , variantId){
                var currentQuantity = parseInt(quantity.text());
                var newQuantity = currentQuantity + 1;
                quantity.text(newQuantity);
                $('.increment-card-'+ productId +'-' +variantId ).siblings('.quantity').text(newQuantity);
                $('.increment-cart-'+ productId +'-' +variantId ).siblings('.quantity-cart').text(newQuantity);
                $('.increment-checkout-'+ productId +'-' +variantId ).siblings('.quantity-checkout').text(newQuantity);
                updateQuantity(productId, variantId , newQuantity)
            }
            updateTotal();
            count();
            discountAdd();
            $(document).on('click' , '.increment' , function (){
                let quantity = $(this).closest('.d-flex').find('.quantity-cart');
                let productId = $(this).closest('.d-flex').data('product');
                let variantId = $(this).closest('.d-flex').data('variant');
                allIncrement(quantity , productId , variantId);
            })
            $(document).on('click' , '.increment-checkout' , function (){
                let quantity = $(this).closest('.d-flex').find('.quantity-checkout');
                let productId = $(this).closest('.d-flex').data('product');
                let variantId = $(this).closest('.d-flex').data('variant');
                allIncrement(quantity , productId , variantId);
            })

            $(document).on('click' , '.increase' , function (){
                let quantity = $(this).closest('.d-flex').find('.quantity');
                let productId = $(this).closest('.d-flex').data('product');
                let variantId = $(this).closest('.d-flex').data('variant');
                allIncrement(quantity , productId , variantId);
            })

            $(document).on('click' , '.decrement' , function (){
                let quantity = $(this).closest('.d-flex').find('.quantity-cart');
                let productId = $(this).closest('.d-flex').data('product');
                let variantId = $(this).closest('.d-flex').data('variant');
                allDecrement(quantity ,productId , variantId);
            })

            $(document).on('click' , '.decrement-checkout' , function (){
                let quantity = $(this).closest('.d-flex').find('.quantity-checkout');
                let productId = $(this).closest('.d-flex').data('product');
                let variantId = $(this).closest('.d-flex').data('variant');
                allDecrement(quantity ,productId , variantId);
            })


            $(document).on('click' , '.decrease' , function (){
                let quantity = $(this).closest('.d-flex').find('.quantity');
                let productId = $(this).closest('.d-flex').data('product');
                let variantId = $(this).closest('.d-flex').data('variant');
                allDecrement(quantity ,productId , variantId);
            })


            function updateQuantity(productId, variantId, quantity) {
                console.log(productId , variantId,quantity)
                updateTotal();
                count();
                discountAdd();
                $.ajax({
                    url: route('update.cart'),
                    type: "POST",
                    data: {
                        product_id: productId,
                        variant_id: variantId,
                        quantity: quantity,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (response) {
                        console.log('Quantity updated');
                    },
                });
            }

            $(document).on('click' , '.checkoutAction' , function (e){
                e.preventDefault()
                let form = $(this).closest('form')[0];
                let formData = new FormData(form);
                let total = $('.total-checkout').text();
                $('.cartData').each(function () {
                    let productId = $(this).data('product');
                    let variantId = $(this).data('variant');
                    let quantity = $(this).find('.quantity-checkout').text();
                    let price = $(this).find('.cart-price').text();
                    formData.append('price[]' , price )
                    formData.append('productId[]' , productId )
                    formData.append('variantId[]' , variantId )
                    formData.append('quantity[]' , quantity )
                });
                $('.all-discounts-apply').each(function () {
                    console.log($('.discount-show-checkout').text())
                    let amount = $(this).find('.discount-show-checkout').text();
                    let code = $(this).find('.discount-show-checkout').data('code');
                    let type = $(this).find('.discount-show-checkout').data('type');
                    let discountName = $(this).find('.discount-show-checkout').data('name');
                    formData.append('amount[]' , amount)
                    formData.append('code[]' , code)
                    formData.append('type[]' , type);
                    formData.append('name[]' , discountName);
                });
                formData.append('total', total);
                $.ajax({
                    url: "{{route('order.store')}}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        window.location.href = '{{route('order.index')}}';
                    },
                    error: function (response){
                        let errors = response.responseJSON.errors;
                        if (errors.first_name) {
                            $('.first_name-error').text(errors.first_name[0]);
                        }
                        if (errors.last_name) {
                            $('.last_name-error').text(errors.last_name[0]);
                        }
                        if (errors.delivery) {
                            $('.delivery-error').text(errors.delivery[0]);
                        }
                        if (errors.country) {
                            $('.country-error').text(errors.country[0]);
                        }
                        if (errors.state) {
                            $('.state-error').text(errors.state[0]);
                        }
                        if (errors.address) {
                            $('.address-error').text(errors.address[0]);
                        }
                    }
                });
            });


            $(document).on('click' , '.close-product-checkout' , function (){
                let deleteId = $(this).data('id');
                let productId = $(this).data('product');
                let cartId = $(this).data('id');
                console.log(productId)
                let row = $(this).closest('.cartData');
                let row1 = $('.offcanvas-body').find('.dlt-'+cartId).parents('.row');
                $.ajax({
                    url: route('delete.cart'),
                    type: "GET",
                    data: {
                        delete_id : deleteId
                    },
                    success: function (response) {
                        if(response.success){
                            row.remove();
                            row1.remove()
                            count();
                            updateTotal();
                            discountAdd();
                        }
                    },
                });
            });
        });
    </script>
@endsection
