@extends('layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div>
                        <div class="row">
                            <div class="col col-12 text-center">
                                <h2 class="">Products</h2>
                                <div class="row">
                                    @foreach($products as $product)
                                      <div class="col-3">
                                          <div class="card product-{{$product->id}}" id="product" style="width: 18rem;" data-product="{{$product->id}}">
                                              <img class="card-img-top" src="{{$product->image_url[0]}}" alt="Card image cap" style="height: 200px;" data-url="{{$product->image_url[0]}}">
                                              <div class="card-body">
                                                  <h5 class="card-title">{{$product->title}}</h5>
                                                  <div class="d-flex">
                                                      @foreach($product->productVariants as $variant)
                                                          @php
                                                              $size = collect(explode(' ', $variant->title))
                                                                ->map(function ($word) {
                                                                  return Str::charAt(ucfirst($word), 0);
                                                                })->implode('');

                                                              $variantExist = $carts->where('variant_id' , $variant->id)->first();

                                                              $variantQuantity =  $carts->where('product_id', $product->id)->where('variant_id', $variant->id)->first()->quantity ?? 1;
                                                         @endphp
                                                          <div>
                                                              <button class="btn btn-outline-info m-2 size" data-id="{{$variant->id}}" data-price="{{$variant->price}}" data-title="{{$variant->title}}" data-product="{{$product->id}}" data-item-exists="{{$variantExist ? 'true' : 'false'}}" data-quantity="{{$variantQuantity}}">{{$size}}</button>
                                                          </div>
                                                      @endforeach
                                                  </div>
                                                  @php

                                                  @endphp
                                                  <div class="d-flex justify-content-between my-2">
                                                      <div class="">
                                                          <span class="fs-5 fw-bold">$</span>
                                                          <span class="fs-5 fw-bold price"></span>
                                                      </div>
                                                          <div class="">
                                                              <a href="#" class="btn btn-success addToCart" id="addToCart" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">Add</a>
                                                          </div>

                                                          <div class="" id="incrementDecrement">
                                                              <div class=" d-flex align-items-end justify-content-around pt-2" >
                                                                  <span class="fs-4 decrease bg-light mx-3 rounded-circle d-flex justify-content-center align-items-center" style="width: 34px; height: 34px;">-</span>
                                                                  <span class="fs-5 quantity"></span>
                                                                  <span class="fs-4 increase bg-light mx-3 rounded-circle d-flex justify-content-center align-items-center" style="width: 34px; height: 34px;">+</span>
                                                              </div>
                                                          </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                    console.log(quantity)
                    let price = $(this).parents('.row').find('.cart-price').text();
                    console.log(price)
                    let total = quantity * price;
                    totalPrice += total;
                });
                $('.total').text(totalPrice)
                $('.subtotal').text(totalPrice)

                if($('.subtotal').text() == 0){
                    console.log("ssdsssss")
                    $('.checkoutBtn').hide();
                    $('.discount-div').hide();
                }
                else{
                    console.log("sasasasasa")
                    $('.checkoutBtn').show();
                    $('.discount-div').show();
                }


                let subtotal = $('.subtotal').text();
                $.ajax({
                    url: route('credit.store.cart'),
                    type: "GET",
                    dataType: 'json',
                    data: {
                        subtotal : subtotal,
                    },
                    success: function (response) {
                        if(response.discount){
                            console.log($('.offcanvas-body').find('.credit-add'))
                            $('.offcanvas-body').find('.credit-add').append(response.discount)
                        }
                        else{
                            console.log('update amount = ' + response.amount)
                            $('.credit-checkout').find('.discount-show-checkout').text(response.amount);
                            $('.credit').find('.discount-show').text(response.amount)
                        }
                        discountAdd();
                    }
                });
                giftCardUpdate();
            }


            function giftCardUpdate(){
                let subtotal = $('.subtotal').text();
                let credit =  $('.credit').find('.discount-show').text();
                let total = 0;
                if(credit){
                    total = parseInt(subtotal) - parseInt(credit)
                }
                else{
                    total = subtotal
                }
                $('.gift-card').addClass('d-flex');
                $('.gift-card').show();
                $('.discount-data').addClass('d-flex');
                $('.discount-data').show();
                let giftCard = $('.gift-card').find('.discount-show').data('code');
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
                            discountAdd()
                        }
                    });
                }
                else{
                    $('.gift-card').removeClass('d-flex');
                    $('.gift-card').hide();
                    $('.discount-data').removeClass('d-flex');
                    $('.discount-data').hide();
                    $('.gift-card').find('.discount-show').text('0')
                }
            }
            function discountAdd() {

                if ($('.discountData').text() != null) {
                    let subtotalText = $('.subtotal').text();
                    let mainTotal = subtotalText;
                    console.log("yyy" + mainTotal);

                    $('.discount-apply').each(function() {
                        let discount = $(this);
                        let type = discount.find('.discount-show').data('type');
                        let amount =  discount.find('.discount-show').text();
                        console.log("calculate amount = " + amount)

                        if (type === 'percentage') {
                            let discountAmount = mainTotal * (amount / 100);
                            console.log(discountAmount)
                            mainTotal = mainTotal - discountAmount;
                        } else if (type === 'fixed') {
                            mainTotal = mainTotal - amount;
                        }
                        if (mainTotal < 0) {
                            mainTotal = 0;
                        }
                    });


                    $('.total').text(mainTotal);
                    $('.total-checkout').text(mainTotal);
                }
            }

            function accessVariant(){
                $('.size').each(function() {
                    let sizeClass = $(this);
                    let variantId = sizeClass.data('id');
                    let productId = sizeClass.data('product');
                    let title = sizeClass.data('title');
                    let price = sizeClass.data('price');
                    let quantity = sizeClass.data('quantity');

                    sizeClass.closest('.card').find('.price').text(price);
                    sizeClass.closest('.card').find('.price').data('title', title);
                    sizeClass.closest('.card').find('.price').data('variant', variantId);

                   sizeClass.closest('.card').find('.quantity').text(quantity);

                    sizeClass.closest('.card').find('.addToCart').data('variant', variantId);
                    sizeClass.closest('.card').find('.addToCart').data('product', productId);

                    sizeClass.closest('.card').find('#incrementDecrement').find('.d-flex').data('variant', variantId);
                    sizeClass.closest('.card').find('#incrementDecrement').find('.d-flex').data('product', productId);

                    sizeClass.closest('.card').find('#incrementDecrement').find('.quantity').data('id', variantId);
                    sizeClass.closest('.card').find('#incrementDecrement').find('.quantity').data('product', productId);

                    sizeClass.closest('.card').find('.decrease').addClass('decrement-card-' + productId + '-' + variantId);
                    sizeClass.closest('.card').find('.increase').addClass('increment-card-' + productId + '-' + variantId);

                    sizeClass.closest('.card').find('.decrease').data('variant', variantId);
                    sizeClass.closest('.card').find('.increase').data('variant', variantId);

                    if (quantity > 0 && sizeClass.data('item-exists')) {
                        sizeClass.closest('.card').find('#addToCart').hide();
                        sizeClass.closest('.card').find('#incrementDecrement').show();
                    } else {
                        sizeClass.closest('.card').find('#addToCart').show();
                        sizeClass.closest('.card').find('#incrementDecrement').hide();
                    }
                });

            }
            accessVariant();
            updateTotal();
            discountAdd()
            count();
            $(document).on('click', '.size', function () {
                let price = $(this).data('price');
                let productId = $(this).data('product');
                let title = $(this).data('title');
                let variant = $(this).data('id');
                let product = $('.product-'+productId).find('.price')

                product.data('title' ,title);
                product.text(price)
                product.data('variant' , variant);
                $('.product-'+productId).find('.addToCart').data('id' , variant)
                $('.product-'+productId).find('#incrementDecrement').find('.d-flex').data('variant' , variant)
                $.ajax({
                    url: route('cart.add'),
                    type: "GET",
                    data: {
                        variant  : variant,
                    },
                    success: function (response) {
                        if(response.status == true){
                            $('.product-'+productId).find('#addToCart').hide()
                            $('.product-'+productId).find('#incrementDecrement').show()
                            $('.product-'+productId).find('#incrementDecrement').find('.quantity').text(response.quantity)
                        }
                        else{
                            $('.product-'+productId).find('#addToCart').show()
                            $('.product-'+productId).find('#incrementDecrement').removeClass('d-block')
                            $('.product-'+productId).find('#incrementDecrement').hide()
                        }
                    },
                });
            })


            $(document).on('click' , '#addToCart', function (){
                let product = $(this).parents('#product');
                let size = product.find('.price').data('title');
                let price = product.find('.price').text();
                let title = product.find('.card-title').text();
                let image = product.find('.card-img-top').data('url');
                let productId = product.data('product');
                let variantId = product.find('.price').data('variant');
                let newQuantity = product.find('.size').data('quantity');
                $.ajax({
                    url: route('cart'),
                    type: "GET",
                    data: {
                        size  : size,
                        price : price,
                        title : title,
                        image : image,
                        product_id : productId,
                        variant_id : variantId,
                        quantity : 1
                    },
                    success: function (response) {

                        if(response.quantity){
                            let row = $('.offcanvas-body').find('.cart-' + response.cartId);
                            row.find('.quantity').text(response.quantity)
                        }
                        product.find('.quantity').text(newQuantity)
                        if(response.variant == variantId){
                            $('.product-'+productId).find('#addToCart').hide()
                            $('.product-'+productId).find('#incrementDecrement').show()
                        }
                        $('.offcanvas-body').find('#allCartData').append(response.html)

                        updateTotal();
                        count();
                        discountAdd()
                    },
                });
            })


            function increment(quantity , productId , variantId , price ){
                var currentQuantity = parseInt(quantity.text());
                var newQuantity = currentQuantity + 1;
                quantity.text(newQuantity);
                if(price == $('.product-' + productId).find('.price').text()){
                    console.log("productId = " + productId);
                    console.log("varianr = " + variantId);
                    $('.increment-card-'+ productId + '-' + variantId).siblings('.quantity').text(newQuantity);
                }
                $('.increment-cart-'+ productId + '-' + variantId).siblings('.quantity-cart').text(newQuantity);
                updateQuantity(productId, variantId , newQuantity)
            }

            function decrement(quantity , productId , variantId , price){
                var currentQuantity = parseInt(quantity.text());
                if(currentQuantity > 1){
                    var newQuantity = currentQuantity - 1;
                    quantity.text(newQuantity);
                    if(price == $('.product-' + productId).find('.price').text()){
                        $('.increment-card-'+ productId + '-' + variantId).siblings('.quantity').text(newQuantity);
                    }
                    $('.decrement-cart-'+ productId + '-' + variantId).siblings('.quantity-cart').text(newQuantity);
                    updateQuantity(productId, variantId , newQuantity)
                }
            }

            $(document).on('click' , '.increment' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-cart');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                let price = $(this).parents('.row').find('.cart-price').text();
                increment(quantity , productId , variantId , price)
            })

            $(document).on('click' , '.increase' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                increment(quantity , productId , variantId)
            })

            $(document).on('click' , '.decrement' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity-cart');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                let price = $(this).parents('.row').find('.cart-price').text();
                decrement(quantity , productId , variantId , price)
            })

            $(document).on('click' , '.decrease' , function (){
                var quantity = $(this).closest('.d-flex').find('.quantity');
                var productId = $(this).closest('.d-flex').data('product');
                var variantId = $(this).closest('.d-flex').data('variant');
                decrement(quantity , productId , variantId)
            })


            function updateQuantity(productId, variantId, quantity) {
                updateTotal();
                count();
                discountAdd()
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

            $(document).on('click' , '.checkoutBtn' , function (){
                window.location.href = route('checkout.show');
            });
        });
    </script>
@endsection
