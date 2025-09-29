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
                                {{--                            <hr class="my-3">--}}
                            @endforeach
                        </div>
                            <div class="position-absolute w-100" style="bottom: 20px; left:20px;">
                                <div class="d-flex justify-content-around">
                                    <label>Sub Total</label>
                                    <div class="d-flex">
                                        <span>$</span>
                                        <span class="total" id="totalAmount"></span>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-around">
                                    <label>Total</label>
                                    <div class="d-flex">
                                        <span>$</span>
                                        <span class="total" id="totalAmount"></span>
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
                $('.total').text(totalPrice)
            }

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

            $(document).on('click' , '.increment' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-cart');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                allIncrement(quantity , productId , variantId);
            })
            $(document).on('click' , '.increment-checkout' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-checkout');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                allIncrement(quantity , productId , variantId);
            })

            $(document).on('click' , '.increase' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                allIncrement(quantity , productId , variantId);
            })

            $(document).on('click' , '.decrement' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-cart');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                allDecrement(quantity ,productId , variantId);
            })

            $(document).on('click' , '.decrement-checkout' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-checkout');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                allDecrement(quantity ,productId , variantId);
            })


            $(document).on('click' , '.decrease' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                allDecrement(quantity ,productId , variantId);
            })


            function updateQuantity(productId, variantId, quantity) {
                console.log(productId , variantId,quantity)
                updateTotal();
                count();
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
                let total = $('#totalAmount').text();
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
                        }
                    },
                });
            });
        });
    </script>
@endsection
